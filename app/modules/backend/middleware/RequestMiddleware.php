<?php
namespace Zejicrm\Modules\Backend\Middleware;

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Zejicrm\Sign;


/**
 * RequestMiddleware
 *
 * Check incoming payload
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * Before the route is executed
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeExecuteRoute(Event $event, Micro $application)
    {
        $method=$application->request->getMethod();
        $url=$application->request->getURI();
        $flag=false;

        //接口文档
        if(strpos($url,'/api')!==false){
            $flag=1;
            return $flag;
        }

        $is_check=0;
        $_checkSign=false;
        $signClass=new Sign($application->config->api->checkSign,$application->config->api->signKey);
        //$application->data_params;
        if($method=='GET'){
            list($data,$sign)=$this->filter($_GET);
            $application->data_params=$data;
            $_checkSign=$signClass->checkSign($data,$sign);
            $flag=true;
            $is_check=1;
        }elseif($method=='POST'){
            list($data,$sign)=$this->filter($_POST);
            $application->data_params=$data;
            $_checkSign=$signClass->checkSign($data,$sign);
            $flag=true;
            $is_check=1;
        }elseif($method=='PUT'){
            list($data,$sign)=$this->filter(file_get_contents("php://input"));
            $application->data_params=$data;
            $_checkSign=$signClass->checkSign($data,$sign);
            $flag=true;
            $is_check=1;
        }elseif($method=='DELETE'){
            $flag=false;
        }else{
            $flag=false;
        }

        if($is_check==1&&$_checkSign==false){
            $application->response->setContent(json_encode(array('code'=>-1,'msg'=>'sign is invild','data'=>array())));
            $application->response->send();
            return false;
        }
        return $flag;

    }

    private function filter($data){
        $sign=null;
        if(isset($data['_url']))
            unset($data['_url']);

        if(isset($data['sign'])){
            $sign=$data['sign'];
            unset($data['sign']);
        }

        if(isset($data['data'])){
            $_data=json_decode($data['data'],true);
            unset($data['data']);
            $data=array_merge($data,$_data);
        }

        return [$data,$sign];
    }


    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}