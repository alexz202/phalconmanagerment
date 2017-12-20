<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/14
 * Time: 14:57
 */
namespace Zejicrm\Modules\Frontend\Services;

use Zejicrm\Modules\Frontend\Models\CustomerRemark;

class Customerremarkservice extends Baseservice {

    protected  $Model='\Zejicrm\Modules\Frontend\Models\CustomerRemark';

    public function __construct($di)
    {
        parent::__construct($di);
    }


    public function addRemark($seed_id,$remark,$user_id){
        $nowtime=time();
        $cmRemark=new CustomerRemark();
        $cmRemark->setUserId($user_id);
        $cmRemark->setCreateTime($nowtime);
        $cmRemark->setSeedId($seed_id);
        $cmRemark->setRemark($remark);
        $cmRemark->setUpdateTime($nowtime);

       return  $cmRemark->save();
    }





}