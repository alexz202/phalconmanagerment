<?php
namespace Zejicrm\Modules\Backend\Controllers;

class IndexController extends ControllerBase
{

    public function getClientMacAction(){
        @exec("arp -a",$array); //执行arp -a命令，结果放到数组$array中
        foreach($array as $value){
//匹配结果放到数组$mac_array
            if(strpos($value,$_SERVER["REMOTE_ADDR"]) && preg_match("/(:?[0-9A-F]{2}[:-]){5}[0-9A-F]{2}/i",$value,$mac_array)){
                $mac = $mac_array[0];
                break;
            }
        }
        echo   $mac;
        die();
    }

    public function indexAction()
    {
        $str='{"mobile_phone":"13404299916\u202c"}';
        $list=json_decode($str,true);
      //  var_dump($list);
        echo $list['mobile_phone'];
       // $ss=json_encode($list);
     die();
        $str1=preg_replace( '/[\x00-\x1F]/','',$str);
        $arr=['str'=>$str,"str1"=>$str1];
        $ss= json_encode($arr);
        var_dump($ss);
        $v=json_decode($ss,true);
        var_dump($v);
        die();
        $str='{"mobile_phone":"13404299916&#8236"}';
        $list=json_decode($str,true);
//        var_dump($list);
//       echo  json_encode($list);
         $s1=$list['mobile_phone'];
       $arr['s1']=floatval($s1);
        $ss=preg_replace( '/[\x00-\x1F]/','',$list['mobile_phone']);
        $arr['ss']=$ss;
       $ssv=json_encode($arr);
        var_dump(json_decode($ssv));
        die();

        return $this->returnValue();
    }


    public  function special_filter($string)
    {
        if (!$string) return '';

        $new_string = '';
        for ($i = 0; isset($string[$i]); $i++) {
            $asc_code = ord($string[$i]);    //得到其asc码

            //以下代码旨在过滤非法字符
            if ($asc_code == 9 || $asc_code == 10 || $asc_code == 13) {
                $new_string .= ' ';
            } else if ($asc_code > 31 && $asc_code != 127) {
                $new_string .= $string[$i];
            }
        }

        return trim($new_string);
    }

        public function getAction(){
        $this->_initialize();
        $id=$this->getParamsValue('id','intval',true);
       return $this->returnValue(200,'success',array($id));
    }

    public function setAction(){
        $this->_initialize();
        $id=$this->getParamsValue('id','intval',true);
        return $this->returnValue(200,'success',array($id));
    }
}

