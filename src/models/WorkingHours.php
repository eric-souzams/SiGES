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
            $result = [
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => 0
            ];
        }

        return $result;
    }
}
