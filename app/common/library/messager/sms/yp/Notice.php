<?php
namespace Zejicrm\Messager\SMS\YP;

use Zejicrm\config\Mobile as smsConfig;

/**
 * 云片短信通道
 * @author zy
 */
class Notice {
    /**
     *  发送单条短信
     */
    public static function sendSms($config,$mobile, $sign, $action, $params = [],$ip = '')
    {
        $smsConfig = smsConfig::$smsConfig;
        $text = sprintf($smsConfig['template_'.$action], $params['code']);

        $data = array(
            'apikey' => $config->ypsmsnotice->apikey,
            'text' => $text,
            'mobile' => $mobile,
        );

        $response = \Zejicrm\Util::post( $config->ypsmsnotice->server, $data);
        $response  = json_decode($response, true);
//        $log['tel'] = $mobile;
//        $log['status'] = $response['code'] == 'OK'?1:2;
//        $log['content'] = $text;
//        $log['reqData'] = json_encode($data,256);
//        $log['resData'] = json_encode($response,256);
//        $log['ip'] = ip2long($ip);
//        $log['createdTime'] = time();
        return $response;
    }

}