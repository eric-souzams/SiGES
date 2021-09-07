<?php

session_start();
requireValidSession();

$date = (new DateTime())->getTimeStamp();
$today = strftime('%d de %B de %Y', $date);
$today = ucwords($today);
$today = str_replace('De', 'de', $today);

loadTemplateView('day_records', ['today' => $today]);