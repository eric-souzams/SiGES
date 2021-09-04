<?php

loadModel('WorkingHours');

$model = new WorkingHours();
$result = $model->loadByUserAndDate(4, date('Y-m-d'));

// $wh = $result->getWorkedInterval()->format('%H:%I');

// $wh = $result->getLunchInterval()->format('%H:%I');

$wh = $result->getExitTime();

print_r($wh);