<?php

// Enable Garbage Collection
gc_enable();

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../library/Zend'),
    realpath(APPLICATION_PATH . '/../'),
    realpath(APPLICATION_PATH . '/../template'),
    realpath(APPLICATION_PATH . '/../classes'),
    realpath(APPLICATION_PATH . '/../externals'),
    realpath(APPLICATION_PATH . '/../conf'),
    realpath(APPLICATION_PATH . '/../modules'),
    realpath(APPLICATION_PATH . '/../modules/CSVMapper'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

//register_shutdown_function("shutdown_error");
// Create application, bootstrap, and run
$application = new Zend_Application(
        APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini'
);

//register_shutdown_function("shutdown_error");

$application->bootstrap()
        ->run();

gc_disable();