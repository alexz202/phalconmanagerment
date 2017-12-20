<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/14
 * Time: 14:57
 */
namespace Zejicrm\Modules\Frontend\Services;


use Zejicrm\Modules\Frontend\Models\Dept;

class Deptservice extends Baseservice {


    public function __construct($di)
    {
        parent::__construct($di);
    }


    public function getDept(){
        $dept= Dept::find();
        $list=array();
        foreach ($dept->toArray() as $v){
            $list[$v['dept_id']]=$v['name'];
        }

        return $list;

    }
    public function getDeptTree(){
        $list=array();
        $dept= Dept::find();
        $list= $dept->toArray();
      return   $this->treeData(0,$list);
    }


    public function treeData($pid,$data){
        $result = array();
        foreach ($data as $v){
            if($v['parent_dept_id']==$pid){
                $v['nodes'] = $this->treeData($v['dept_id'],$data);
                if(count($v['nodes'])>0)
                $result[] = array(
                    'text'=>$v['name'],
                    'dept_id'=>$v['dept_id'],
                    'href'=>"/user/allList?dept_id={$v['dept_id']}",
              //      'parent_dept_id'=>$v['parent_dept_id'],
                    'nodes'=>$v['nodes']
                );
                else
                    $result[] = array(
                        'text'=>$v['name'],
                        'dept_id'=>$v['dept_id'],
                        'href'=>"/user/allList?dept_id={$v['dept_id']}",
                        //      'parent_dept_id'=>$v['parent_dept_id'],
                     //   'nodes'=>$v['nodes']
                    );
            }
        }
        return $result;
    }


    public function getOneChind($pid){
        $dept= Dept::find();
        $list= $dept->toArray();
        $result= $this->getChindren($pid,$list);
        return $result;
    }

    public function getChindren($pid,$data){
        $ids=[];
        foreach ($data as $v){
            if($v['parent_dept_id']==$pid){
                $ids[]=$v['dept_id'];
                $ids= array_merge($ids,$this->getChindren($v['dept_id'],$data));
            }
        }
        return $ids;
    }





}