<?php

session_start();
requireValidSession();

$user = $_SESSION['USER'];

$date = (new DateTime())->getTimeStamp();
$today = strftime('%d de %B de %Y', $date);
$today = ucwords($today);
$today = str_replace('De', 'de', $today);

loadTemplateView('day_records', [
    'today' => $today,
    'is_admin' => $user['is_admin']
]);