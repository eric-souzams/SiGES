<?php

session_start();
requireValidSession();

$mUser = new User();
$mWorkingHours = new WorkingHours();

$activeUsersCount = $mUser->getUsersCount();
$absentUsers = $mWorkingHours->getAbsentUsers();

$date = (new DateTime())->format('Y-m');
$seconds = $mWorkingHours->getWorkedTimeInMonth($date);
$totalHours = explode(':', getTimeStringFromSeconds($seconds))[0];

loadTemplateView('manager_report', [
    'activeUsersCount' => $activeUsersCount,
    'absentUsers' => $absentUsers,
    'totalHours' => $totalHours
]);