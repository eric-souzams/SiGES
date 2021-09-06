<?php

class WorkingHours extends Model
{

    protected static $table = "working_hours";
    protected static $columns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time',
    ];

    public function loadByUserAndDate($userId, $workDate)
    {
        $result = $this->findByUserAndDate($userId, $workDate);

        if (!$result) {
            $payload = [
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => 0
            ];
            $result = new WorkingHours();
            $result->loadData($payload);
        }

        return $result;
    }

    public function getNextTime()
    {
        if (!$this->getValue('time1')) return 'time1';
        if (!$this->getValue('time2')) return 'time2';
        if (!$this->getValue('time3')) return 'time3';
        if (!$this->getValue('time4')) return 'time4';
        return null;
    }

    public function getActiveClock()
    {
        $nextTime = $this->getNextTime();

        if($nextTime === 'time1' || $nextTime === 'time3') {
            return 'exitTime';
        } else if($nextTime === 'time2' || $nextTime === 'time4') {
            return 'workedInterval';
        } else {
            return null;
        }
    }

    public function innout($time)
    {
        $timeColumn = $this->getNextTime();
        if (!$timeColumn) {
            throw new AppException("Você já fez os 4 batimentos do dia!");
        }

        $this->setValue($timeColumn, $time);
        $this->setValue('worked_time', getSecondsFromDateInterval($this->getWorkedInterval()));

        if ($this->getValue('id')) {
            $this->update();
        } else {
            $this->insert();
            $this->update();
        }
    }

    public function getWorkedInterval()
    {
        [$t1, $t2, $t3, $t4] = $this->getTimes();

        $part1 = new DateInterval('PT0S');
        $part2 = new DateInterval('PT0S');

        if ($t1) $part1 = $t1->diff(new DateTime());
        if ($t2) $part1 = $t1->diff($t2);

        if ($t3) $part2 = $t3->diff(new DateTime());
        if ($t4) $part2 = $t3->diff($t4);

        return sumInterval($part1, $part2);
    }

    public function getLunchInterval()
    {
        [, $t2, $t3,] = $this->getTimes();

        $lunchInterval = new DateInterval('PT0S');

        if ($t2) $lunchInterval = $t2->diff(new DateTime());
        if ($t3) $lunchInterval = $t2->diff($t3);

        return $lunchInterval;
    }

    public function getExitTime()
    {
        [$t1,,, $t4] = $this->getTimes();

        $workday = DateInterval::createFromDateString('8 hours');

        if (!$t1) {
            return (new DateTimeImmutable())->add($workday);
        } elseif ($t4) {
            return $t4;
        } else {
            $total = sumInterval($workday, $this->getLunchInterval());
            return $t1->add($total);
        }
    }

    private function getTimes()
    {
        $times = [];

        $this->getValue('time1') ? array_push($times, getDateFromString($this->getValue('time1'))) : array_push($times, null);
        $this->getValue('time2') ? array_push($times, getDateFromString($this->getValue('time2'))) : array_push($times, null);
        $this->getValue('time3') ? array_push($times, getDateFromString($this->getValue('time3'))) : array_push($times, null);
        $this->getValue('time4') ? array_push($times, getDateFromString($this->getValue('time4'))) : array_push($times, null);

        return $times;
    }

    public function getBalance()
    {
        if(!$this->getValue('time1') && !isPastWorkday($this->getValue('work_date'))) {
            return '';
        }

        if($this->getValue('worked_time') == DAILY_TIME) {
            return '';
        }

        $balance = $this->getValue('worked_time') - DAILY_TIME;
        $balanceString = getTimeStringFromSeconds(abs($balance));
        $sign = $this->getValue('worked_time') >= DAILY_TIME ? '+' : '-';
        return "{$sign}{$balanceString}";
    }

    public function getMonthlyReport($userId, $date)
    {
        $startDate = getFisrtDayOfMonth($date)->format('Y-m-d');
        $endDate = getLastDayOfMonth($date)->format('Y-m-d'); 

        $mWorkingHours = new WorkingHours();
        $result = $mWorkingHours->findByUser($userId, $startDate, $endDate);

        return $result;
    }
}
