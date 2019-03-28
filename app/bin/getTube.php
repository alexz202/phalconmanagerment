#!/usr/bin/env php
<?php

/**
 * Created by PhpStorm.
 * User: alexzhu
 * Date: 2018/12/10
 * Time: 5:51 PM
 */

require_once __DIR__ . '/../../vendor/autoload.php';
define('APP_PATH', dirname(__DIR__));
define('BASE_PATH',dirname(dirname(__DIR__)));

use Phalcon\Di\FactoryDefault;
use Phalcon\Cache\Frontend\Data as FrontData;
use Zejicrm\RedisEx as BackRedisEx;
use Phalcon\Queue\Beanstalk\Extended as BeanstalkExtended;
use Phalcon\Queue\Beanstalk\Job;
use Zejicrm\worker\WorkerProviderFactory;

date_default_timezone_set('Asia/Shanghai');
$config = new \Phalcon\Config\Adapter\Ini("../config/config_online.ini");

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
    'Zejicrm'        => APP_PATH . '/common/library/',
));
$loader->register();

$di = new FactoryDefault();

$host = $config->beanstalkd->host;
$prefix=$config->beanstalkd->prefix;

$beanstalk = new BeanstalkExtended([
    'host'   => $host,
    'prefix' => $prefix,
]);

$di->set('redis', function() use($config) {
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

$tubeInfo=$beanstalk->getTubeStats('mailWorker');

var_dump($tubeInfo);


