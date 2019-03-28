<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use Zejicrm\Modules\Backend\Controllers\IndexController;
use Zejicrm\Modules\Backend\Controllers\CustomerController;
use Zejicrm\Modules\Backend\Controllers\ApiController;
use Zejicrm\Modules\Backend\Controllers\ActiveController;

//创建接口声明绑定 类型

//$index = new MicroCollection();
// Set the main handler. ie. a controller instance
//$index->setHandler(new IndexController());
//$index->setPrefix('/index');
//$index->get('/', 'indexAction');
//$app->mount($index);


//customer
$customer = new MicroCollection();
$customer->setHandler(new CustomerController());
$customer->setPrefix('/customer');
$customer->get('/create', 'createAction');
$customer->get('/multipleCreate', 'multipleCreateAction');
$customer->post('/create', 'createAction');
$customer->post('/multipleCreate', 'multipleCreateAction');
$app->mount($customer);


////API 正式上线此模块请屏蔽
//$api = new MicroCollection();
//$api->setHandler(new ApiController());
//$api->setPrefix('/api');
//$api->get('/customer','customerAction');
//$app->mount($api);

$active = new MicroCollection();
$active->setHandler(new ActiveController());
$active->setPrefix('/active');
$active->get('/createUser','createUserAction');
$active->post('/createUser','createUserAction');
$app->mount($active);