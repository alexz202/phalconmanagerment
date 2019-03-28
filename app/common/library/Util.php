<?php
/**
 * 公用方法
 */
namespace Zejicrm;

class Util {

    public static $platform = [
        1 =>    'ios',
        2 =>    'android',
        3 =>    'winphone',
        4 =>    'pc',
        5 =>    'other'
    ];
	/* 获取客户端IP */
	public static function getClientIP()
	{
		if (isset($_SERVER)) {
			if (isset($_SERVER ["HTTP_X_FORWARDED_FOR"])) {
				$realip = $_SERVER ["HTTP_X_FORWARDED_FOR"];
			} else 
				if (isset($_SERVER ["HTTP_CLIENT_IP"])) {
					$realip = $_SERVER ["HTTP_CLIENT_IP"];
				} else {
					$realip = isset($_SERVER ["REMOTE_ADDR"]) ? $_SERVER ["REMOTE_ADDR"] : '127.0.0.1';
				}
		} else {
			if (getenv("HTTP_X_FORWARDED_FOR")) {
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			} else 
				if (getenv("HTTP_CLIENT_IP")) {
					$realip = getenv("HTTP_CLIENT_IP");
				} else {
					$realip = getenv("REMOTE_ADDR");
				}
		}
		
		return addslashes($realip);
	}
	
	/* post请求 */
	public static function post($url, $data = null, $type='POST', $referer=null)
	{
	    $ch = curl_init();
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_URL, $url);
		if ($data) {
			if($type=='POST'){
			    if(is_array($data)) $data = http_build_query($data,"","&");
				curl_setopt($ch,CURLOPT_POST,1);
				curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
			}else{
				curl_setopt($ch,CURLOPT_HTTPGET,1);
			}
		}
		if ($referer) curl_setopt($ch,CURLOPT_REFERER, $referer);
		curl_setopt($ch,CURLOPT_TIMEOUT, 10);
		ob_start();
		curl_exec($ch);
		$contents = ob_get_contents();
		ob_end_clean();
		curl_close($ch);
		
		return $contents;
	}
	
	/* get请求 */
	public static function get($url, $data = null) 
	{
	    if(is_array($data)){
	        $data = http_build_query($data);
	        if(preg_match('/\?/', $url) == false){
	            $data = '?'.$data;
	        }
	        $url .= $data;
	    }
	    return self::post($url, null, 'GET');
	}
	
	/* jsonp解析 */
	public static function jsonp_decode($str)
	{
	    $match = preg_match('#{.*}#', $str, $matchret);
	    if($match){
	        return json_decode($matchret[0], true);
	    }
	    return null;
	}
	
	/* 手机号格式检查 */
	public static function checkMobile($mobile) 
	{
	    $mobile_preg = '/(^13\d|^14[57]|^15[012356789]|^18[012356789]|^17[0236789])\d{8}$/';
	    return preg_match($mobile_preg, $mobile);
	}
    
    /* 参数格式化 */
    public static function stringFormat($str) 
    {
    	$numArgs = func_num_args () - 1;
    
    	if ($numArgs > 0) {
    		$arg_list = array_slice ( func_get_args (), 1 );
    
    		for($i = 0; $i < $numArgs; $i ++) {
    			$str = str_replace ( "{" . $i . "}", $arg_list [$i], $str );
    		}
    	}
    	return $str;
    }
    

	/**
	 * 打印调用堆栈信息
	 * @return string
	 */
	public static function stackTrace(){
		$array =debug_backtrace();
		//var_dump($array);
		unset($array[0]);
		$html = '';
		foreach($array as $row)
		{
			$html .=($row['file'] ?: '系统').':'.($row['line'] ?: '未知 ').'行,调用方法:'.$row['function']."<br>";
		}
		return $html;
	}

    public static function timeFormat($stampTime)
    {
        $now = time();
        $dur = $now - $stampTime;
        if ($dur < 60) {
            return '刚刚';
        } else if ($dur < 3600) {
            return floor($dur / 60) . '分钟前';
        } else if ($dur < 10800) {// 3小时
            return floor($dur / 3600) . '小时前';
        }
        return date('Y-m-d H:i', $stampTime);
    }
    //敏感词过滤
    public static function filter_msg(&$msg){
        $block_words = \config\BlockWords::$words['block_words'];
        return  strtr($msg, $block_words);
    }

    //XSS安全过滤
    public static function remove_xss($val) {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <java\0script>
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

        // straight replacements, the user should never need these since they're normal characters
        // this prevents like <IMG SRC=@avascript:alert('XSS')>
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            // ;? matches the ;, which is optional
            // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

            // @ @ search for the hex values
            $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
            // @ @ 0{0,7} matches '0' zero to seven times
            $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
        }

        // now the only remaining whitespace attacks are \t, \n, and \r
        $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link',
            'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy',
            'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint',
            'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick',
            'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged',
            'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave',
            'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish',
            'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
            'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout',
            'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste',
            'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart',
            'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange',
            'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);

        $found = true; // keep replacing as long as the previous round replaced something
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(&#0{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
                $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }
        return $val;
    }

    /**
     * 字符串截取，支持中文和其他编码
     * @static
     * @access public
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断显示字符
     * @return string
     */
    public static function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
        if(function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif(function_exists('iconv_substr')) {
            $slice = iconv_substr($str,$start,$length,$charset);
            if(false === $slice) {
                $slice = '';
            }
        }else{
            $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("",array_slice($match[0], $start, $length));
        }
        if (strlen($slice) > $length && $suffix){
            $slice = $slice.'...';
        }
        return $slice;
    }

    public static function filterSubject($value){
        preg_match('/[^(]*/',$value,$matchs);
        return $matchs[0];
    }

    public static function filterUrlParams($value){
        $arr = parse_url($value);
        if(!empty($arr)) {
            if(isset($arr['query'])){
                $query=$arr['query'];
                $path=$arr['path'];
                $query = explode("&", trim($query));
                if (count($query) > 0) {
                    foreach ($query as $item) {
                        $v = explode('=', $item);
                        $list[trim($v[0])] =urldecode($v[1]);
                    }
                    return $path . '?' . http_build_query($list);
                }
            }
        }
        return $value;
    }

    public static function filterUrlParamsClear($value,$key){
        $arr = parse_url($value);
        if(!empty($arr)) {
            if(isset($arr['query'])){
                $query=$arr['query'];
                $path=$arr['path'];
                $query=explode("&",trim($query));
                if(count($query)>0){
                    foreach ($query as $item){
                        $v=explode('=',$item);
                        $list[trim($v[0])]=urldecode($v[1]);
                    }
                    if($key=="province"){
                        unset($list['province']);
                        unset($list['city']);
                    }else{
                        unset($list[$key]);
                    }
                    return $path.'?'.http_build_query($list);
                }
            }
        }
        return $value;
    }
}
?>