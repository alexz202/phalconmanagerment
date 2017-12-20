<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/12/20
 * Time: 10:52
 */
namespace Zejicrm;

class CurlToolkit
{
    public static function request($method, $url, $params = array(), $conditions = array())
    {
        $conditions['userAgent']      = isset($conditions['userAgent']) ? $conditions['userAgent'] : '';
        $conditions['connectTimeout'] = isset($conditions['connectTimeout']) ? $conditions['connectTimeout'] : 10;
        $conditions['timeout']        = isset($conditions['timeout']) ? $conditions['timeout'] : 10;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $conditions['userAgent']);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $conditions['connectTimeout']);
        curl_setopt($curl, CURLOPT_TIMEOUT, $conditions['timeout']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            //TODO
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        } elseif ($method == 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        } elseif ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        } elseif ($method == 'PATCH') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        } else {
            if (!empty($params)) {
                $url = $url.(strpos($url, '?') ? '&' : '?').http_build_query($params);
            }
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($curl);
        $curlinfo = curl_getinfo($curl);
        $header = substr($response, 0, $curlinfo['header_size']);
        $body   = substr($response, $curlinfo['header_size']);
        curl_close($curl);
        if (empty($curlinfo['namelookup_time'])) {
            return array();
        }
        if (isset($conditions['contentType']) && $conditions['contentType'] == 'plain') {
            return $body;
        }
        $body = json_decode($body, true);
        return $body;
    }

    public static function curlUploadFile( $url, $params = array(),$timeout=10,$connectTimeout=10){
        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
//        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       if( $error=curl_errno($curl)){
           die($error);
       }
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function sendStreamFile($url, $file){

        if(file_exists($file)){

            $opts = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'content-type:application/x-www-form-urlencoded',
                    'content' => file_get_contents($file)
                )
            );

            $context = stream_context_create($opts);
            $response = file_get_contents($url, false, $context);
            $ret = json_decode($response, true);
            return $ret['success'];

        }else{
            return false;
        }

    }

}