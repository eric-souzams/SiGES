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

    public function innout($time)
    {
        $timeColumn = $this->getNextTime();
        if (!$timeColumn) {
            throw new AppException("Você já fez os 4 batimentos do dia!");
        }

        $this->setValue($timeColumn, $time);
        if ($this->getValue('id')) {
            $this->update();
        } else {
            $this->insert();
            $this->update();
        }
    }
}
