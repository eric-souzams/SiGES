<?php

session_start();
requireValidSession();

loadModel('WorkingHours');

$user = $_SESSION['USER'];
$model =  new WorkingHours();
$userRecords = $model->loadByUserAndDate($user['id'], date('Y-m-d'));

try {
    $currentTime = strftime('%H:%M:%S', time());
    $userRecords->innout($currentTime);
    addSuccessMessage('Ponto inserido com sucesso!');
} catch (AppException $e) {
    addErrorMessage($e->getMessage());
}

header('location: day_records.php');