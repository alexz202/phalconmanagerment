<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'Zejicrm\Models' => APP_PATH . '/common/models/',
    'Zejicrm'        => APP_PATH . '/common/library/',
]);

/**
 * Register module classes
 */
$loader->registerClasses([
    'Zejicrm\Modules\Frontend\Module' => APP_PATH . '/modules/frontend/Module.php',
    'Zejicrm\Modules\Cli\Module'      => APP_PATH . '/modules/cli/Module.php'
]);

//
//$loader->registerDirs(array(
//    APP_PATH . '/Modules/Frontend/models/'
//));

$loader->register();
