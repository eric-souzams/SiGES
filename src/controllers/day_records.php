<?php

session_start();
requireValidSession();

loadModel('WorkingHours');

$date = (new DateTime())->getTimeStamp();
$today = strftime('%d de %B de %Y', $date);
$today = str_replace('a', "A", $today);

$user = $_SESSION['USER'];
$model =  new WorkingHours();
$userRecords = $model->loadByUserAndDate($user['id'], date('Y-m-d'));

loadTemplateView('day_records', [
    'today' => $today,
    'records' => $userRecords
    ]);