<?php
/**
 * Created by PhpStorm.
 * User: alexzhu
 * Date: 2018/12/25
 * Time: 5:20 PM
 */

namespace Zejicrm;


use duncan3dc\Forker\Exception;

class BeanstalkToolkit
{
    protected $_dependencyInjector;
    private $redis_set_key="set_beanstalkd:%s:%s";

    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }


    /*
     * 放入队列
     */
    public function putInTube($tube,$data,$delay=2){
        $nowTs=time();
        $common=array(
            'createTs'=>$nowTs,
            'tube'=>$tube
        );
        $data=array_merge($data,$common);
        $result=$this->_dependencyInjector['beanstalk']->putInTube($tube, json_encode($data), array('delay' => $delay));
        if($result){
            $data['jobId']=$result;
           return  $this->setJobForRedis($tube,intval($result),$nowTs,$data);
        }
        return false;
    }


    public function failJobReset(){
        $keys="set_beanstalkd:*";
        $result=$this->_dependencyInjector['redis']->keys($keys);
        if($result){
            foreach ($result as $key){
               $value=$this->_dependencyInjector['redis']->get($key);
               if(!empty($value)){
                   $data=json_decode($value,true);
                   if(!empty($data)){
                     $result=$this->putInTube($data['tube'],$data);
                     if($result){
                         $this->_dependencyInjector['redis']->del($key);
                     }
                   }
               }
            }
        }
    }


    public function setJobForRedis($tube,$jobId,$createTs,$data){
        $key=$this->combineKey($tube,$jobId,$createTs);
        return $this->_dependencyInjector['redis']->set($key,json_encode($data));
    }

    public function getJobForRedis($tube,$jobId,$createTs){
        $key=$this->combineKey($tube,$jobId,$createTs);
        return $this->_dependencyInjector['redis']->get($key);
    }

    public function deleteForRedis($tube,$jobId,$createTs){
        $key=$this->combineKey($tube,$jobId,$createTs);
        if($this->_dependencyInjector['redis']->exists($key)){
            $res= $this->_dependencyInjector['redis']->del($key);
            return $res;
        }
        return true;
    }

    private function combineKey($tube,$jobId,$createTs){
       return  $key=sprintf($this->redis_set_key,$tube,md5($jobId.'-'.$createTs));
    }

}