<?php
/**
 * Created by PhpStorm.
 * User: alexzhu
 * Date: 2018/12/26
 * Time: 11:15 AM
 */
namespace Zejicrm\worker;

class WorkerProviderFactory{
    public static function create($worker){
        if(empty($worker)){
            throw new Exception("worker 类型不存在");
        }

        $class=__NAMESPACE__."\\".ucfirst($worker);
        return new $class();
    }
}