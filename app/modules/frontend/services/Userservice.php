<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/14
 * Time: 14:57
 */
namespace Zejicrm\Modules\Frontend\Services;


use Zejicrm\Modules\Frontend\Models\User;

class Userservice extends Baseservice {


    public function __construct($di)
    {
       parent::__construct($di);
    }
    protected $redis_all_user_sort_by_name_key='getAllUserByNameSort';

    protected $redis_all_sales_person_key='getAllSalesPerson';

    protected $redis_all_user_key='getAllUser';

    /**
     * 获取所有者信息  需要缓存
     */
    public function getAllUser($state=''){
        $that = $this;
        if($state==''){
            $key="getAllUser";
        }else{
            $key="getAllUser_$state";
        }
        return $this->fetchCached("$key",0,1,$state,function($state) use($that){
            $params['order']="sub_account_id asc";
            if($state=='')
                $sql="select * from tb_user where is_delete=0 order by sub_account_id asc";
            else
                $sql="select * from tb_user where is_delete=0 and state={$state}  order by sub_account_id asc";
            $list=$this->di['dbadmin']->fetchAll($sql);
            return $list;
        });
    }


    public function getAllUserByNameSort(){
       $list= $this->getAllUserBySortNameFromRedis();
       if($list){
           return json_decode($list,true);
       }else{
           $User='\Zejicrm\Modules\Frontend\Models\User';//需要全命名
           $sql="select * from tb_user where is_delete=0 order by convert(substr(staff_name,1,1) using 'GBK')";
           $list=$this->di['dbadmin']->fetchAll($sql);
           $this->setAllUserBySortNameFromRedis($list);
           return $list;
       }
    }


    public function getAllSalesPerson(){
        $list=$this->getRedisValue($this->redis_all_sales_person_key);
        if($list){
            return json_decode($list,true);
        }else {
            $sql = "select user_id,staff_name,sub_account_id,sales_level from tb_user where is_duty_sales=1 and is_delete=0 order by convert(substr(staff_name,1,1) using 'GBK') ";
            $list = $this->di['dbadmin']->fetchAll($sql);
            $this->setRedisValue($this->redis_all_sales_person_key,json_encode($list));
            return $list;
        }
    }

    public function delAllSalesPerson(){
        $this->di['redis']->del($this->redis_all_sales_person_key);
    }


    public function setAllUserBySortNameFromRedis($list){
        return $this->di['redis']->set($this->redis_all_user_sort_by_name_key, json_encode($list));
    }

    public function getAllUserBySortNameFromRedis(){
        return $this->di['redis']->get($this->redis_all_user_sort_by_name_key);
    }

    public function delAllUserBySortNameFromRedis(){
        return $this->di['redis']->del($this->redis_all_user_sort_by_name_key);
    }

    public function delAllUserFromRedis(){
        return $this->di['redis']->del($this->redis_all_user_key);
    }

    public function clearCacheByRedis(){
        $this->delAllUserBySortNameFromRedis();
        $this->delAllSalesPerson();
        $this->delAllUserFromRedis();
    }


    public function getAllSaleUser($value=1){
        $user=User::findByIsDutySales($value);
        return  $user->toArray();
    }


    public function updateSubAccountIdByUsers($seed_ids,$params){
        $Customer='\Zejicrm\Modules\Frontend\Models\Customer';//需要全命名
        $sql="update {$Customer}  set sub_account_id={$params['sub_account_id']},update_date={$params['update_date']},customer_state=2 where seed_id in($seed_ids)";
        $query=$this->di['modelsManager']->createQuery($sql);
        return $query->execute();

    }


    //1:ids 2:list 3:treeData
    public function getOneGroupChild($id,$type=1,$params=array()){
        $data=$this->getAllUser();
        if($type==1){
            return  $this->_getChindIds($id,$data,'group_leader_id','user_id');
        }elseif($type==2){
            return  $this->_getChindList($id,$data,'group_leader_id','user_id');
        }else{
            return  $this->_treeData($id,$data,'group_leader_id','user_id',$params);
        }

    }



    public function updateGroupLeader($child_list,$aim_level){
        $User='\Zejicrm\Modules\Frontend\Models\User';
        $nowtime=time();
        $res=1;
        foreach ($child_list as $user_id=>$level){
            $add_level=$level+intval($aim_level);
            $sql="update {$User} set level={$add_level},update_date=$nowtime where user_id= ({$user_id})";
            $query=$this->di['modelsManager']->createQuery($sql);
            $res*= $query->execute()->success();
        }
        return $res;
    }


    public function getNotExistUser(){

        $account_list=[];
        $has_account_list=[];
        $add_user=[];
        $user_seed_ids=[];
        $modify_seeds=[];

        $sql="select * from tb_user";
        $all_exist_users=$this->di['dbadmin']->fetchAll($sql);
        foreach ($all_exist_users as $user){
            $sub_account_id=$user['sub_account_id'];
            $user_seed_ids[]=$user['user_id'];
            $has_account_list[$sub_account_id]=$user['user_id'];
        }

        $sql2="select seed,SUB_ACCOUNT_ID,STAFF_NAME,PARENT_STAFF_SEED,DEPT,`POSITION`,USER_ROLE,staff_alias from T_SUB_USERINFO";
        $all_users=$this->di['dbadmin']->fetchAll($sql2);
        foreach ($all_users as $user){
            $sub_account_id=$user['SUB_ACCOUNT_ID'];
            $seed=$user['seed'];
            if(!isset($has_account_list[$sub_account_id])){
                $add_user[]=$sub_account_id;
                if(in_array($seed,$user_seed_ids)){
                    $modify_seeds[]=$seed;
                }
                $update_sql="insert into tb_user set sub_account_id='{$sub_account_id}',staff_name='{$user['STAFF_NAME']}',dept={$user['DEPT']},password='e10adc3949ba59abbe56e057f20f883e',user_role={$user['USER_ROLE']},create_date=999999";
                $this->di['dbadmin']->execute($update_sql);
            }
        }


    }

}