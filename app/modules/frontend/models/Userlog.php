<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/4
 * Time: 13:21
 */

namespace Zejicrm\Modules\Frontend\Models;

class Userlog extends \Phalcon\Mvc\Model
{
    protected $id;

    protected $user_id;
    protected $user_name;
    protected $createTime;
    protected $action;
    protected $remark;


    public function setId($id){
        $this->id=$id;
    }

    public function setUserId($user_id){
        $this->user_id=$user_id;
    }

    public function setUserName($userName){
        $this->user_name=$userName;
    }


    public function setCreateTime($createTime){
        $this->createTime=$createTime;
    }

    public function setAction($action){
        $this->action=$action;
    }

    public function setRemark($remark){
        $this->remark=$remark;
    }


    public function getId(){
       return  $this->id;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getUserName(){
        return $this->user_name;
    }


    public function getCreateTime(){
        return $this->createTime;
    }

    public function getAction(){
        return $this->action;
    }

    public function getRemark(){
        return $this->remark;
    }


    public function initialize()
    {
        $this->setConnectionService('dblog');//不同的库
//        $this->setWriteConnectionService ('dblog');
//        $this->setReadConnectionService ('dblog');
//        $this->setSchema("zeji_crm_log");
        $this->setSource("tb_user_log");
    }

    public function getSource()
    {
        return 'tb_user_log';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbResource[]|TbResource|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbResource|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }



}