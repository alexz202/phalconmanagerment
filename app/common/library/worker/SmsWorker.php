<?php
/**
 * Created by PhpStorm.
 * User: alexzhu
 * Date: 2018/12/26
 * Time: 11:24 AM
 */
namespace Zejicrm\worker;
use Zejicrm\BeanstalkToolkit;
use Zejicrm\SmsCommon as SmsCommon;

class SmsWorker implements \Zejicrm\worker\BaseWorkerInf{

    public function addWorker($config,$di,$job){
        $jobId=$job->getId();
        $str= $job->getBody();
        $content=json_decode($str,true);
        $mobile=$content['mobile'];
        $sign=$content['sign'];
        $action=$content['action'];
        $params=$content['params'];
        $tube=$content['tube'];
        $createTs=$content['createTs'];
        $smsClass=new SmsCommon($di,false);
        $result=$smsClass->sendSms($config,$mobile,$sign,$action,$params);
        if($result){
            //成功删除REDIS记录
            $beanstalkToolkit =new BeanstalkToolkit($di);
            $beanstalkToolkit->deleteForRedis($tube,$jobId,$createTs);
        }
        return true;
    }
}