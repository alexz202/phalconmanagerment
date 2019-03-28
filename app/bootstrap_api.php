<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Events\Manager;
use Zejicrm\Modules\Backend\Middleware\NotFoundMiddleware;
use Zejicrm\Modules\Backend\Middleware\RequestMiddleware;
use Zejicrm\Modules\Backend\Middleware\ResponseMiddleware;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
//是不是生产环境，配置不同的Config文件
define('PRODUCT',1);

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers the services that
     * provide a full stack framework. These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    /**
     * Include Services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader_api.php';
    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);
    $eventsManager = new Manager();

    /**
     * Include routes
     */
    require APP_PATH . '/config/collection_api.php';

    $eventsManager->attach('micro', new NotFoundMiddleware());
    $app->before(new NotFoundMiddleware());

    $eventsManager->attach('micro', new RequestMiddleware());
    $app->before(new RequestMiddleware());

    $eventsManager->attach('micro', new ResponseMiddleware());
    $app->after(new ResponseMiddleware());

    //初始化参数
    $app->data_params=[];
    $app->setEventsManager($eventsManager);

    /**
     * Handle the request
     */
    $app->handle();




} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
