<?php

setlocale(LC_ALL, 'pt_BR.utf-8', 'portuguese.utf-8');
date_default_timezone_set('Brazil/East');

//consts utils
define('DAILY_TIME', 60 * 60 * 8);

//folders
define('CONFIG_PATH', realpath(dirname(__FILE__) . '/../config'));
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));
define('VIEW_PATH', realpath(dirname(__FILE__) . '/../views'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/../views/template'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__) . '/../controllers'));
define('EXCEPTION_PATH', realpath(dirname(__FILE__) . '/../exceptions'));

//files
require_once(realpath(CONFIG_PATH) . '/database.php');
require_once(realpath(CONFIG_PATH) . '/loader.php');
require_once(realpath(CONFIG_PATH) . '/session.php');
require_once(realpath(CONFIG_PATH) . '/date_utils.php');
require_once(realpath(CONFIG_PATH) . '/utils.php');

require_once(realpath(MODEL_PATH) . '/Model.php');
require_once(realpath(MODEL_PATH) . '/User.php');
require_once(realpath(MODEL_PATH) . '/WorkingHours.php');

require_once(realpath(EXCEPTION_PATH) . '/AppException.php');
require_once(realpath(EXCEPTION_PATH) . '/ValidationException.php');