<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/10
 * Time: 14:40
 */
namespace Zejicrm\Models;

class Base extends \Phalcon\Mvc\Model{

    /*
     * 构建 TYPE:and ,in ,between, or ,notin ;qt:=,>,<,like...etc
     */
    public static function createBuiler($from,$modelsManager,$condition,$list,$orderBy=null,$roleFilter=0,$roleParams=array()){
        $builder= $modelsManager->createBuilder();
        $builder->from($from);
        foreach ($condition as $k=>$v){
            $type=isset($v['type'])?$v['type']:"and";
            $qt=isset($v['qt'])?$v['qt']:'=';

            $where= $type.'where';
            if($type=='or' ||$type=='and' ){
                if($qt=="like"){
                    $builder->$where("$k $qt :$k:",[$k=>"%".$list[$k]."%"]);
                }else{
                    $builder->$where("$k $qt :$k:",[$k=>$list[$k]]);
                }
            }elseif($type=='between'){
                $i=1;
                $value_l=[];
                //between (key,1,10)不支持 字符连接转数组再处理
                if(is_string($list[$k])){
                    $list[$k]=explode(',',$list[$k]);
                }

                foreach ($list[$k] as $v){
                    if(!empty($v)){
                        $value_l[$k.$i]=$v;
                    }
                    $i++;
                }
                if(count($value_l)==2){
                    $builder->$where($k,$value_l[$k.'1'],$value_l[$k.'2']);
                }elseif(count($value_l)==1){
                    if(isset($value_l[$k.'1'])){
                        $builder->where("$k >= {$value_l[$k.'1']}");
                    }else{
                        $builder->where("$k <= {$value_l[$k.'2']}");
                    }
                }
            }
            else{
                if(is_array($list[$k]))
                    $builder->$where($k,$list[$k]);
                else
                    $builder->$where($k,explode(',',$list[$k]));
            }
        }

        /*
         * 根据角色过滤数据
         */
        if($roleFilter==1){
            if($roleParams['data_level']==2){
             //   $user_ids=$roleParams['s_data_user_ids'];
                $user_ids=array_merge($roleParams['data_user_ids'],$roleParams['s_data_user_ids']);
                $builder->inWhere('user_id',$user_ids);
            }
        }

        if(!empty($orderBy)){
            $builder->orderBy($orderBy);
        }

        return $builder;
    }


}