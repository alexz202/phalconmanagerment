<?php
namespace Zejicrm;

class Log{

    const LOG_PRESERVE = true;

    /* 错误 */
    public static function error($tip, $params = array())
    {
        self::out('error', $tip, $params, 'error');
    }

    /* debug */
    public static function debug($tip, $params = array())
    {
        //if (self::LOG_LEVEL < 9) return;

        self::out('debug', $tip, $params, 'debug');
    }

    public static function log($tip, $params = ''){
        $currtime = time();
      $dir = BASE_PATH.'/cache/log';
        $fname = $dir.'/log-'. date("Ymd",$currtime) . '.log';
        if (!@file_exists($fname)) {
            @touch($fname);
            @chmod($fname, 0777);
        }
        error_log($params . "\n",3,$fname);
    }

    private static function out($level, $tip, $params = null)
    {
        $currtime = time();
        $dir = BASE_PATH.'/cache/log';
        $fname = $dir.'/'.$level.'-'. date("Ymd",$currtime) . '.log';

        $mesg = date("Y-m-d H:i:s") . "【". $tip . "】\t";
        if (!empty($params) && is_array($params)){
            foreach ( $params as $k => $v ) {
                if(is_array($v)) {
                    $v = json_encode($v, \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES);
                }/*
			if (self::LOG_PRESERVE==true) { // convert special character
				$k = str_replace(array('&','=',','),array('&&','&=','&,'),$k);
				$v = str_replace(array('&','=',','),array('&&','&=','&,'),$v);
			}*/
                $mesg .= $k . '=' . $v . ',';
            }
        }
        if (!@file_exists($fname)) {
            @touch($fname);
            @chmod($fname, 0777);
        }
        error_log($mesg . "\n",3,$fname);
    }

    public static function info($tip, $params = array())
    {
        self::out('info', $tip, $params, 'info');

    }

    public static function email($tip, $params = array())
    {
        self::out('email', $tip, $params, 'info');

    }

}