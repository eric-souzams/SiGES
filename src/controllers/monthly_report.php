<?php

session_start();
requireValidSession();

$currentDate = new DateTime();

$user = $_SESSION['USER'];
$users = [];
$selectedUserId = $user['id'];

if($user['is_admin']) {
    $uModel = new User();
    $users = $uModel->getAllUsers();

    $selectedUserId = isset($_POST['user']) ? $_POST['user'] : $user['id'];
}

$selectedPeriod = isset($_POST['period']) ? $_POST['period'] : $currentDate->format('Y-m');
$periods = [];

for ($yearDiff = 0; $yearDiff <= 1; $yearDiff++) {
    $year = date('Y') - $yearDiff;
    for($month = 12; $month >= 1; $month--) {
        $date = new DateTime("{$year}-{$month}-1");
        $periods[$date->format('Y-m')] = ucfirst(strftime('%B de %Y', $date->getTimestamp()));
    }
}

$model =  new WorkingHours();
$registries = $model->getMonthlyReport($selectedUserId, $selectedPeriod);

$report = [];
$workday = 0;
$sumOfWorkedTime = 0;
$lastDay = getLastDayOfMonth($selectedPeriod)->format('d');

for ($day = 1; $day <= $lastDay; $day++) {
    $date = $selectedPeriod . '-' . sprintf('%02d', $day);

    if (isPastWorkday($date)) $workday++;

    if (isset($registries[$date])) {
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
    'balance' => "{$sign}{$balance}",
    'selectedPeriod' => $selectedPeriod,
    'selectedUserId' => $selectedUserId,
    'periods' => $periods,
    'users' => $users
]);
