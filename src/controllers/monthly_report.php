<?php

session_start();
requireValidSession();

$currentDate = new DateTime();

$user = $_SESSION['USER'];

$model =  new WorkingHours();
$registries = $model->getMonthlyReport($user['id'], $currentDate);

$report = [];
$workday = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayOfMonth($currentDate)->format('d');

for($day = 1; $day <= $lastDay; $day++) {
    $date = $currentDate->format('Y-m') . '-' . sprintf('%02d', $day);

    if(isPastWorkday($date)) $workday++;

    if(isset($registries[$date])) {
        $registry = $registries[$date];

        $sumOfWorkedTime += $registry->getValue('worked_time');

        array_push($report, $registry);
    } else {
        $mWorkingHours = new WorkingHours();
        $mWorkingHours->loadData([
            'work_date' => $date,
            'worked_time' => 0,
            'time1' => null,
            'time2' => null,
            'time3' => null,
            'time4' => null,
        ]);
        array_push($report, $mWorkingHours);
    }
}

$expectedTime = $workday * DAILY_TIME;
$balance = getTimeStringFromSeconds(abs($sumOfWorkedTime - $expectedTime));
$sign = ($sumOfWorkedTime >= $expectedTime) ? '+' : '-';

loadTemplateView('monthly_report', [
    'report' => $report,
    'sumOfWorkedTime' => getTimeStringFromSeconds($sumOfWorkedTime),
    'balance' => "{$sign}{$balance}"
]);
