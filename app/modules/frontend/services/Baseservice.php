<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/14
 * Time: 14:57
 */
namespace Zejicrm\Modules\Frontend\Services;


class Baseservice{


    protected $di;
    protected $redisCache=array();

    public function __construct($di)
    {
        $this->di = $di;
    }



    protected function mutipleInsert($table,$data,$keys){
        $keysstr=join(',',$keys);
        $sql="replace into $table ({$keysstr}) values ";
        foreach ($data as $v){
            $sql.="(" .join(',',$v)."),";
        }

        $sql=substr($sql,0,-1);
        return $this->di['db']->execute($sql);
    }



    public function setRedisValue($key,$value){
        return $this->di['redis']->set($key, $value);
    }

    public function getRedisValue($key){
        return $this->di['redis']->get($key);
    }


    /*
     * 获取所有子集的list 一维数组
     */
    public function _getChindList($pid,$data,$pkay,$key,$level=1){
        $list=[];
        foreach ($data as $v){
            if($v[$pkay]==$pid){
                $v['level']=$level;
                $list[]=$v;
                $list= array_merge($list,$this->_getChindList($v[$key],$data, $pkay,$key,$level+1));
            }
        }
        return $list;
    }

    /*
    * 获取所有子集的list
    */
    public function _getChindIds($pid,$data,$pkay,$key){
        $ids=[];
        foreach ($data as $v){
            if($v[$pkay]==$pid){
                $ids[]=$v[$key];
                $ids= array_merge($ids,$this->_getChindIds($v[$key],$data, $pkay,$key));
            }
        }
        return $ids;
    }



    public function _treeData($pid,$data,$pkay,$key,$params){
        $result = array();
        foreach ($data as $v){
            if($v[$pkay]==$pid){
                $_arr=array();
                $v['nodes'] = $this->_treeData($v[$key],$data,$pkay,$key,$params);
                if(count($v['nodes'])>0)
                    foreach ($params as $k=>$value){
                        $_arr[$k]=$v[$value];
                        $_arr['nodes']=$v['nodes'];
                    }
                else{
                    foreach ($params as $k=>$value){
                        $_arr[$k]=$v[$value];
                    }
                }
                $result[]=$_arr;
            }
        }
        return $result;
    }


    protected function fetchCached()
    {
        $args = func_get_args();
        $callback = array_pop($args);

        $key =  array_shift($args);
        $timeout =  array_shift($args);
        $jsJson =  array_shift($args);

        if(isset($this->redisCache[$key])){
            return $this->redisCache[$key];
        }

        $getRedisInfo=$this->di['redis']->get($key);
        if ($getRedisInfo) {
            //如果是JSON 解析JSON
            if($jsJson==1)
                return $this->redisCache[$key]=json_decode($getRedisInfo,true);
            else
                return $this->redisCache[$key]=$getRedisInfo;
        }
        $this->redisCache[$key]=call_user_func_array($callback, $args);

        //如果要保存JSON
        if($jsJson==1)
            $value=json_encode($this->redisCache[$key]);
        else
            $value=$this->redisCache[$key];

        if($timeout>0)
            $this->di['redis']->set($key,$value,$timeout);
        else
            $this->di['redis']->set($key,$value);
        return $this->redisCache[$key];
    }


}