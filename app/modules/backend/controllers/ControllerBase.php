<?php
namespace Zejicrm\Modules\Backend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    public function _initialize(){
        $this->setCommonParams();
    }

    public function returnValue($code=200,$msg='success',$data=array()){
        return array($code,$msg,$data);
    }


    public function setCommonParams(){
        $params=$this->di['application']->data_params;
        if($this->di['application']->config->api->checkCommon==1){
            $this->platform=$this->getParamsValue('platform','intval',true,true);
            $this->platform=$this->getParamsValue('channel','intval',true,true);
//            $this->device_id=$this->getParamsValue('device_id','strval',true,true);
//            $this->login_id=$this->getParamsValue('login_id','intval',true,true);
            $this->client_ts=$this->getParamsValue('timestamp','intval',false,true);
            if($this->client_ts)
            $this->client_version=$this->getParamsValue('version','strval',true,true);
//            $this->verdor=$this->getParamsValue('verdor','strval',true,true);
        }
    }

    public function getParamsValue($key,$type='strval',$necessary=false,$common=false){
        $params=$this->di['application']->data_params;
        if(!isset($params[$key])){
            if($necessary){
                $payload = [
                    'code'    => 0,
                    'message' => "$key is not exist",
                    'data' => [],
                ];
               $this->response->setJsonContent($payload);
               $this->response->send();
                exit();
            }else{
                return $common;
            }
        }else{
            if($type=='strval'){
                return trim($params[$key]);
            }elseif($type=='array'){
                return $params[$key];
            }else{
                return call_user_func($type,trim($params[$key]));
            }
        }
    }

}
