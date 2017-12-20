<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/14
 * Time: 14:57
 */
namespace Zejicrm\Modules\Frontend\Services;


class Customerservice extends Baseservice {


    public function __construct($di)
    {
        parent::__construct($di);
    }


    public function updateSubAccountIdByUsers($seed_ids,$params){
        $Customer='\Zejicrm\Modules\Frontend\Models\Customer';//需要全命名
        $sql="update {$Customer}  set sub_account_id='{$params['sub_account_id']}',own_date='{$params['update_date']}',update_date='{$params['update_date']}',customer_state=2,user_id={$params['user_id']} where seed_id in($seed_ids)";
        $query=$this->di['modelsManager']->createQuery($sql);
        return $query->execute();
    }

    public function getCustomerCountByUserIdDay($user_id,$day){
        $sql="select count(*) as cnt,user_id from tb_customer  where user_id =$user_id and FROM_UNIXTIME(own_date,'%Y%m%d')=$day ";
        $result=$this->di['db']->fetchOne($sql);
        if($result){
            return intval($result['cnt']);
        }else
            return 0;
    }

    public function getCustomerFollowCountByUserIdDay($user_id,$day){
        $sql="select count(*) as cnt,user_id from tb_customer_follow  where user_id =$user_id and FROM_UNIXTIME(create_date,'%Y%m%d')=$day ";
        $result=$this->di['db']->fetchOne($sql);
        if($result){
            return intval($result['cnt']);
        }else
            return 0;
    }

    /*
     * 获取某一天需要的跟进客户数量
     */
    public function getToCustomerFollowCountByUserIdDay($user_id,$day){
        $sql="select count(*) as cnt,user_id from tb_customer where user_id =$user_id and FROM_UNIXTIME(follow_next_time,'%Y%m%d')=$day ";
        $result=$this->di['db']->fetchOne($sql);
        if($result){
            return intval($result['cnt']);
        }else
            return 0;
    }



    public function getOrderCountByUserIdDay($user_id,$day){
        $sql="select count(*) as cnt,user_id from tb_order  where user_id =$user_id and FROM_UNIXTIME(execute_end_date,'%Y%m%d')=$day ";
        $result=$this->di['db']->fetchOne($sql);
        if($result){
            return intval($result['cnt']);
        }else
            return 0;
    }

    public function getCustomerByMobiles($mobiles){
        $mobiles_str=implode(',',$mobiles);
        $sql="select * from tb_customer  where mobile_phone in ({$mobiles_str}) order by seed_id asc";
        $result=$this->di['db']->fetchAll($sql);
        $list=array();
        if($result){
            foreach ($result as $v){
                $list[$v['mobile_phone']]=intval($v['seed_id']);
            }
        }
        return $list;
    }


    public function updateCustomerByIds($ids,$updateParams){
        $nowtime=time();
        $update_list=[];
        foreach ($updateParams as $k=>$v){
            if(is_string($v))
              $update_list[]="$k='$v'";
            else
                $update_list[]="$k=$v";
        }
//        $update_list[]="update_date=".$nowtime;
        $update_str=join(',',$update_list);
        $sql="update tb_customer  set {$update_str}  where seed_id in({$ids})";
       return  $result=$this->di['db']->execute($sql);
    }

}