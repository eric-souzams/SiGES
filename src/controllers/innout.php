<?php

session_start();
requireValidSession();

loadModel('WorkingHours');

$user = $_SESSION['USER'];
$model =  new WorkingHours();
$userRecords = $model->loadByUserAndDate($user['id'], date('Y-m-d'));

$currentTime = strftime('%H:%M:%S', time());

$userRecords->innout($currentTime);

header('location: day_records.php');