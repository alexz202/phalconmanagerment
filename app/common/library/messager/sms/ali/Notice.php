<?php
namespace Zejicrm\Messager\SMS\Ali;
use Zejicrm\config\Mobile as smsConfig;
use Zejicrm\Util;
use Zejicrm\Log;

/**
 * 阿里短信通道
 * 参考：https://help.aliyun.com/product/44282.html?spm=5176.sms-template.102.8.29a01cbefjaicZ
 * @author zy
 */
class Notice {
    /**
     *  发送单条短信
     * $tel 111,2222,333 多个
     */
    public static function sendSms($config,$tel, $sign, $template, $data = [])
    {
        $configParam = $config->alismsnotice;
        $templateParam = smsConfig::$smsConfig;
        $params['PhoneNumbers'] = $tel;
        $params['SignName'] = isset($templateParam['signName'][$sign])?$templateParam['signName'][$sign]:$templateParam['signName']['zejiwangxiao'];
        Log::info('$template'.$template);
        $template = self::getTemplate($template);
        Log::info('$template'.$template);
        print_r($params);
        if(isset($templateParam[$template]))
        {
            if( substr($tel,0,2) == '00' ){
                $params['TemplateCode'] = $templateParam[$template]['code_gw'];
            }else{
                $params['TemplateCode'] = $templateParam[$template]['code'];
            }
        }else{
            Log::error('短信模版不存在', $template);
            return false;
        }
        $params['TemplateParam'] = $data;
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        Log::info('smsParams:',$params);
//        print_r($params);
        // 发送请求,此处可能会抛出异常，注意catch
        $content = self::request(
            $configParam['accessKeyId'],
            $configParam['accessKeySecret'],
            $configParam['server'],
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
        return array('code'=>$content->Code, 'message'=>$content->Message);
    }


    //检查手机号
    private static function checkTelSend($tel, $template)
    {
        $redis = Redis::getInstance('user')->getRedis();
        $key = RedisKey::SMS_CODE.":{$tel}:{$template}";
        return $redis->get($key);

    }

    // IP白名单黑名单
    private static function checkIp(){
        $conf = self::getConfig();
        $remoteIp = Util::getClientIP();
        // 白名单与黑名单
        if( !empty($conf['writeListIP']) ){
            if( !in_array($remoteIp,$conf['writeListIP']) ){
                return false;
            }
        }else{
            if( in_array($remoteIp,$conf['blackListIP'])  ){
                return false;
            }
        }
        return true;
    }

    /**
     * 生成签名并发起请求
     *
     * @param $accessKeyId string AccessKeyId (https://ak-console.aliyun.com/)
     * @param $accessKeySecret string AccessKeySecret
     * @param $domain string API接口所在域名
     * @param $params array API具体参数
     * @param $security boolean 使用https
     * @return bool|\stdClass 返回API接口调用结果，当发生错误时返回false
     */
    public static function request($accessKeyId, $accessKeySecret, $domain, $params, $security=false) {
        $apiParams = array_merge(array (
            "SignatureMethod" => "HMAC-SHA1",
            "SignatureNonce" => uniqid(mt_rand(0,0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId" => $accessKeyId,
            "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
            "Format" => "JSON",
        ), $params);
        ksort($apiParams);
        $sortedQueryStringTmp = '';
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . self::encode($key) . "=" . self::encode($value);
        }

        $stringToSign = "GET&%2F&" . self::encode(substr($sortedQueryStringTmp, 1));

        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&",true));

        $signature = self::encode($sign);

        $url = ($security ? 'https' : 'http')."://{$domain}/?Signature={$signature}{$sortedQueryStringTmp}";

        try {
            $content = Util::get($url);
            return json_decode($content);
        } catch( \Exception $e) {
            return false;
        }
    }

    private static function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    //获取短信内容:因为短信内容是在阿里生成
    private static function getSmsContent($sign, $template, $params = [])
    {
        $configParam = smsConfig::$smsConfig;
        $sign = isset($configParam['signName'][$sign])?$configParam['signName'][$sign]:$configParam['signName']['zejiwangxiao'];
        $template = $configParam['templateCode'][$template]['text'];
        if(is_array($params))
        {
            foreach($params as $key => $value)
            {
                $key = '${'.$key.'}';
                $template = str_replace($key, $value, $template);
            }
            $content = "【{$sign}】{$template}";
//            $content = str_replace(array_keys($params), $params, stripslashes($template));
        }else{
            $content = "【{$sign}】{$template}";
        }
        return $content;
    }

    private static function getTemplate($template){
            $templateCode = 'template'.$template;
        return $templateCode;
    }
}

