<?php

use Phalcon\Loader;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\Redis as BackRedis;
use Phalcon\Cache\Frontend\Output as FrontOutput;
use Zejicrm\RedisEx as BackRedisEx;
use Phalcon\Mvc\Model\Manager as ModelsManager;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return new Ini(APP_PATH  . "/config/config.ini");
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Configure the Volt service for rendering .volt templates
 */
$di->setShared('voltShared', function ($view) {
    $config = $this->getConfig();

    $volt = new VoltEngine($view, $this);

//    //add function
//    $compiler = $volt->getCompiler();
//
//// This binds the function name 'shuffle' in Volt to the PHP function 'str_shuffle'
//    $compiler->addFunction('showViewValue', function ($resolvedArgs, $exprArgs) use ($compiler) {
//        // Resolve the first argument
//        $firstArgument = $compiler->expression($exprArgs[0]['expr']);
//        $secondArgument=$exprArgs[1];
//        // Checks if the second argument was passed
//        var_dump($exprArgs);
//    });

//    $volt->callMacro('pagination');

    $volt->setOptions([
        'compiledPath' => function($templatePath) use ($config) {
            $basePath = $config->application->appDir;
            if ($basePath && substr($basePath, 0, 2) == '..') {
                $basePath = dirname(__DIR__);
            }

            $basePath = realpath($basePath);
            $templatePath = trim(substr($templatePath, strlen($basePath)), '\\/');

            $filename = basename(str_replace(['\\', '/'], '_', $templatePath), '.volt') . '.php';

            $cacheDir = $config->application->cacheDir;
            if ($cacheDir && substr($cacheDir, 0, 2) == '..') {
                $cacheDir = __DIR__ . DIRECTORY_SEPARATOR . $cacheDir;
            }

            $cacheDir = realpath($cacheDir);

            if (!$cacheDir) {
                $cacheDir = sys_get_temp_dir();
            }

            if (!is_dir($cacheDir . DIRECTORY_SEPARATOR . 'volt' )) {
                @mkdir($cacheDir . DIRECTORY_SEPARATOR . 'volt' , 0755, true);
            }

            return $cacheDir . DIRECTORY_SEPARATOR . 'volt' . DIRECTORY_SEPARATOR . $filename;
        }
    ]);


    //自定义过滤器
    $compiler = $volt->getCompiler();
    $compiler->addFilter("filterSubject", function($resolvedArgs, $exprArgs) {
        return "Zejicrm\Util::filterSubject(".$resolvedArgs.")";
    });

    $compiler->addFilter("filterUrlParams", function($resolvedArgs, $exprArgs) {
        return "Zejicrm\Util::filterUrlParams(".$resolvedArgs.")";
    });

    $compiler->addFilter("filterUrlParamsClear", function($resolvedArgs, $exprArgs) {
        return "Zejicrm\Util::filterUrlParamsClear(".$resolvedArgs.")";
    });

    return $volt;
});



$di->setShared('redisCache', function () {
    $config = $this->getConfig();
    $frontCache = new FrontData(
        [
            "lifetime" =>  $config->get('redis')->get('lifetime'),
        ]
    );

    $cache = new BackRedis(
        $frontCache,
        [
            "host"       => $config->get('redis')->get('host'),
            "port"       => $config->get('redis')->get('port'),
            "auth"       => $config->get('redis')->get('auth'),
            "persistent" => $config->get('redis')->get('persistent'),
            "index"      => $config->get('redis')->get('index'),
        ]
    );

    return $cache;
});



/*
 * redis phpredis
 */
$di->setShared('redis', function () {
    $config = $this->getConfig();
    $frontCache = new FrontData(
        [
            "lifetime" =>  $config->get('redis')->get('lifetime'),
        ]
    );

    $redis=new redis();
    $redis->connect($config->redis->host,$config->redis->port,15);
    $redis->auth($config->redis->auth);
    $redis->select($config->redis->index);
    $cache= new BackRedisEx($frontCache,array(
        'redis'=>$redis
    ));
    return $cache;
});

/*
 * file cache
 */

$di->setShared('fileCache', function () {
    $config = $this->getConfig();
    $frontCache = new FrontOutput(
        [
            "lifetime" => $config->get('file')->get('lifetime'),
        ]
    );

    // Set the cache directory
    $backendOptions = [
        "cacheDir" => BASE_PATH."/cache/",
    ];
    $cache = new BackFile($frontCache, $backendOptions);

    return $cache;
});


$di->set(
    "modelsManager",
    function() {
        $m= new ModelsManager();
        //$m->registerNamespaceAlias('Models','Zejicrm\Modules\Frontend\Models'); 别名没有？？
        return $m;
    }
);



//beanstalkd
$di->set('beanstalk',function (){
    $config = $this->getConfig();
    $beanstalk = new BeanstalkExtended(array(
        'host'   => $config->beanstalkd->host,
        'prefix' => $config->beanstalkd->prefix,
    ));
    return $beanstalk;
});