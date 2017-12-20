<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/14
 * Time: 14:57
 */
namespace Zejicrm\Modules\Frontend\Services;


use Zejicrm\Modules\Frontend\Models\ColumnsIndex;

class ColumnsIndexservice extends Baseservice {

    protected  $Model='\Zejicrm\Modules\Frontend\Models\ColumnsIndex';

    public function __construct($di)
    {
        parent::__construct($di);
    }


    //type 1:> 2<:
    public function getNearId($controller,$sortV,$type=1){
        if($type==1){
            $qt=">";
            $orderby=" order by sort asc";
        }else{
            $qt="<";
            $orderby=" order by sort desc";
        }

         $sql="select * from $this->Model where sort {$qt} {$sortV}  and controller='$controller' $orderby limit 1  ";
        $query=$this->di['modelsManager']->createQuery($sql);
        $res= $query->execute();
        if($res){
            return $res;
        }else
            return false;

    }


    public function getShowColumnsByController($controller){
        $sql="select * from $this->Model where controller='$controller' and show=1";
        $query=$this->di['modelsManager']->createQuery($sql);
        $res= $query->execute();
        if($res){
            return $res;
        }else
            return false;


    }





}