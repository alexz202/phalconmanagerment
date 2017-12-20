<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Config\Adapter\Json as configJson;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Zejicrm\Security;
use Phalcon\Flash\Session as FlashSession;


/**
 * Registering a router
 */
$di->setShared('router', function () {
    $router = new Router();

    $router->setDefaultModule('frontend');

    return $router;
});

/**
 * The URL component is used to generate all kinds of URLs in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Starts the session the first time some component requests the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning'
    ]);
});


$di->set('flashSession', function () {
        return new FlashSession([
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning'
        ]);
    }
);


$di->setShared('aclJson', function () {
   // $aclJson= new configJson(APP_PATH  . "/json/acl.json");
    $aclJson= new configJson(BASE_PATH  . "/cache/acl.json");
    return $aclJson;
});



$di->setShared('dictJson', function () {
    $dictJson= new configJson(APP_PATH  . "/json/dict.json");
    return $dictJson;
});


/**
* Set the default namespace for dispatcher
*/
$di->setShared('dispatcher', function() use($di){
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Zejicrm\Modules\Frontend\Controllers');

    //Obtain the standard eventsManager from the DI
    $eventsManager = $di->getShared('eventsManager');

    //Instantiate the Security plugin
    $security = new Security($di);

    //Listen for events produced in the dispatcher using the Security plugin
    $eventsManager->attach('dispatch', $security);

    //Bind the EventsManager to the Dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

/*
 *db_log
 */
$di->setShared('dblog', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->databaselog->adapter;
    $params = [
        'host'     => $config->databaselog->host,
        'username' => $config->databaselog->username,
        'password' => $config->databaselog->password,
        'dbname'   => $config->databaselog->dbname,
        'charset'  => $config->databaselog->charset
    ];

    if ($config->databaselog->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});


$di->setShared('dbadmin', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->databaseadmin->adapter;
    $params = [
        'host'     => $config->databaseadmin->host,
        'username' => $config->databaseadmin->username,
        'password' => $config->databaseadmin->password,
        'dbname'   => $config->databaseadmin->dbname,
        'charset'  => $config->databaseadmin->charset
    ];

    if ($config->databaselog->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});



$di->setShared('sysLog', function () {
    $config = $this->getConfig();
    $file=$config->get('syslog')->get('file');
    $filepath=BASE_PATH.'/logs/'.$file;
    $logger = new FileAdapter($filepath);
    return $logger;
});