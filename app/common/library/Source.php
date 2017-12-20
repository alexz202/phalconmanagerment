<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/12/20
 * Time: 10:33
 */
namespace Zejicrm;

class Source {

    private $key=null;
    private $config=null;
    public function __construct($config)
    {
        $this->config=$config;
        $this->key=$config['sign_key'];
    }

    public function uploadFile($params,$inf='upload_pic_inf',$is_random_name=0,$designated_path='',$makeThumb=0,$ext=''){
        $url=$this->config[$inf];
        $data=[];
        if(!empty($is_random_name))
            $data['is_random_name']=$is_random_name;
        if(!empty($designated_path))
            $data['designated_path']=$designated_path;
        if(!empty($makeThumb))
            $data['makeThumb']=$makeThumb;
        if(!empty($ext))
            $data['ext']=$ext;
        $sign=$this->makeSign($data);
        $data['sign']=$sign;
        $url.="?".http_build_query($data);
        return CurlToolkit::curlUploadFile($url,$params);
    }


    private function makeSign($data)
    {
        $signKey = $this->key;
        ksort($data);
        foreach ($data as $key => $value) {
            if (is_array($value)) $data[$key] = json_encode($value, \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES);
        }
        $sign = md5(implode($signKey, $data));
        return $sign;
    }

}