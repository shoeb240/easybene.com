<?php
//header('Access-Control-Allow-Origin *');
header("Access-Control-Allow-Origin: *");

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

// Register namespace "My" which contains custom forms, plugins, decorators etc
require_once 'Zend/Loader/Autoloader.php';
$autoLoader = Zend_Loader_Autoloader::getInstance();
$autoLoader->registerNamespace('My_');


/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);


// front controller instance
$front = Zend_Controller_Front::getInstance();

// Disable output buffering
$front->setParam('disableOutputBuffering', true);

//$translate = new Zend_Translate(
//    array(
//        'adapter' => 'array',
//        'content' => array(
//            'archive' => 'archiv',
//            'year' => 'jahr',
//            'month' => 'monat',
//            'account' => 'acnt',
//            'users' => 'usr'
//        ),
//        'locale' => 'en'
//    )
//);
//$translate->setLocale('en');
//Zend_Controller_Router_Route::setDefaultTranslator($translate);
//


// Set application wide confguration
Zend_Registry::set('bidNumberPerMonth', 10);
Zend_Registry::set('invitedMemberLimit', 20);
Zend_Registry::set('PAYPAL_a3', '200');
Zend_Registry::set('PAYPAL_a4', '5');
Zend_Registry::set('ADMIN_CURRENCY', 'SGD');
Zend_Registry::set('BUSINESS_EMAIL', 'shoeb5_1184333684_biz@gmail.com');


Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination-control.phtml');

// Register custom plugins 
$front->registerPlugin(new My_Plugin_Route());
$front->registerPlugin(new My_Plugin_Auth());
//$front->registerPlugin(new My_Plugin_Navigation());
//$front->registerPlugin(new My_Plugin_HeaderFooter());
error_reporting(9);
try {
    $application->bootstrap()->run();
} catch(Exception $e) {
    echo '=='.$e->getMessage();
}