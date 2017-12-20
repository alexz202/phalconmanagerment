<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/14
 * Time: 14:57
 */
namespace Zejicrm\Modules\Frontend\Services;


use Zejicrm\Modules\Frontend\Models\ColumnsIndex;

class Rolescreenservice extends Baseservice {

    protected  $Model='\Zejicrm\Modules\Frontend\Models\RoleScreen';

    public function __construct($di)
    {
        parent::__construct($di);
    }


    public function getShowColumnsByController($controller,$role_id){
        $sql="select * from $this->Model where controller='$controller' and role_id=$role_id";
        $query=$this->di['modelsManager']->createQuery($sql);
        $res= $query->execute();
        if($res){
            return $res;
        }else
            return false;


    }





}