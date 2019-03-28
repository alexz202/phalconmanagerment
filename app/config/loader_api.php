<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * Register Namespaces
 */
$loader->registerNamespaces([
    'Zejicrm\Models' => APP_PATH . '/common/models/',
    'Zejicrm\Lib'        => APP_PATH . '/common/library/',
    'Zejicrm\Modules\Backend' => APP_PATH . '/modules/backend/',
    'Zejicrm\Modules\Frontend' => APP_PATH . '/modules/frontend/',
    'Zejicrm\Modules\Backend\Controllers' => APP_PATH . '/modules/backend/controllers/',
    'Zejicrm\Modules\Backend\Models' => APP_PATH . '/modules/backend/models/',
    'Zejicrm\Modules\Backend\Middleware' => APP_PATH . '/modules/backend/middleware/',
    'Zejicrm\Modules\Frontend\Services' => APP_PATH . '/modules/frontend/services',
    'Zejicrm\Modules\Frontend\Models' => APP_PATH . '/modules/frontend/models',
    'Zejicrm'        => APP_PATH . '/common/library/',
]);

/**
 * Register module classes
 */
$loader->registerClasses([
    'Zejicrm\Modules\Frontend\Module' => APP_PATH . '/modules/frontend/Module.php',
    'Zejicrm\Modules\Backend\Module' => APP_PATH . '/modules/backend/Module.php',
    'Zejicrm\Modules\Cli\Module'      => APP_PATH . '/modules/cli/Module.php',
]);

$loader->register();
