<?php

// Define base
define('BP', dirname(getcwd()));
define('PS', PATH_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', BP . DS . 'app');
// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(realpath(BP . DS . 'lib'),get_include_path(),)));

if('development' == APPLICATION_ENV): define('ROOT', 'http://' . $_SERVER['SERVER_NAME'] . '/');
else: define('ROOT', 'http://' . $_SERVER['SERVER_NAME'] . '/edulab/www/');
endif;

require_once 'Zend/Application.php';
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/app.ini');
$application->bootstrap()->run();

?>