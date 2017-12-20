<?php

namespace Zejicrm\Modules\Frontend\Controllers;

use Zejicrm\Modules\Frontend\Models\Resource;
use Zejicrm\Modules\Frontend\Models\Userlog;
use Zejicrm\Modules\Frontend\Services\Tongjiservice;


class IndexController extends ControllerBase
{

    public function initialize()
    {

        $this->view->setVar('treeId',1);
        parent::initialize();
    }

    public function indexAction()
    {
        if ($this->_isLogin()) {
//            $tj=(new Tongjiservice($this->di))->getUserDayTotal($this->user_id);
//            $this->view->setVar('tj',$tj);
//            $start=date('Y-m-d 00:00:00');
//            $end=date('Y-m-d 23:59:59');
//            $url="/customer/potential?follow_next_time[]=".urlencode($start)."&follow_next_time[]=".urlencode($end);
//            $this->view->setVar('followtodayUrl',$url);
        }else{
            return  $this->response->redirect('/login/index');
        }
    }

    public function testAction(){

//        echo date('W',strtotime('2011-01-03'));
//
//        var_dump($this->get_week(2016));
//        var_dump($this->get_week(2010));
//        var_dump($this->get_week(2011));
        die();
       // $this->view->setVar('title','test demo');
    }

}

