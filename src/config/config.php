<?php

date_default_timezone_set('Brazil/East');
// setlocale(LC_TIME, 'portuguese.utf-8');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese'); 

//folders
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));

require_once(realpath(dirname(__FILE__) . '/database.php'));