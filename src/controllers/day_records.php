<?php

session_start();
requireValidSession();

$date = (new DateTime())->getTimeStamp();
$today = strftime('%d de %B de %Y', $date);
$today = str_replace('a', "A", $today);

loadTemplateView('day_records', ['today' => $today]);