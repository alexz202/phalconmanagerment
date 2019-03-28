<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2018/11/26
 * Time: 11:07
 */
namespace Zejicrm;
use Zejicrm\Messager\SMS\Ali\Notice as aliSMS;
use Zejicrm\Messager\SMS\YP\Notice as ypSMS;
use Zejicrm\Modules\Frontend\Models\Smslog;

class SmsCommon{

    protected $_dependencyInjector;
    protected $_usebeanstalk;

    public function __construct($dependencyInjector, $usebeanstalk=false)
    {
        $this->_dependencyInjector = $dependencyInjector;
        $this->_usebeanstalk = $usebeanstalk;
    }

    public static function sendSms($config,$mobile, $sign='zejiwangxiao', $action, $params){
        $result=0;
        //TODO OTHERS LOGIC
        $smsLog=new Smslog();
        if($config->sms->use_sms_value==1){
           $res= aliSMS::sendSms($config,$mobile, $sign, $action, $params);
            if($res['code']=='ok'){
                $result=1;
            }
            $data=array(
                'tel'=>$mobile,
                'result'=>$result,
                'msg'=>$res['message'],
                'code'=>$res['code']
            );
        }else{
            $res= ypSMS::sendSms($config,$mobile, $sign, $action, $params);
            if($res['code']=='ok'){
                $result=1;
            }
            $data=array(
                'tel'=>$mobile,
                'result'=>$result,
                'msg'=>$res['msg'],
                'code'=>$res['code']
            );
        }
        $smsLog->save($data);
        return $result;
    }

    public function sendSmsToQueue($config,$mobile, $sign, $action, $params){
        $arr=array(
            'mobile'=>$mobile,
            'sign'=>$sign,
            'action'=>$action,
            'param'=>$params,
        );
        $result=(new BeanstalkToolkit($this->_dependencyInjector))->putInTube("smsWorker",$arr);
        if($result){
            $this->_dependencyInjector['sysLog']->log("sendSmsToQueue,".json_encode($result));
        }
        return $result;
    }
}