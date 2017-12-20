<?php

namespace Zejicrm\Modules\Frontend\Models;

class Syslog extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $user_name;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $controller;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $action;

    /**
     *
     * @var string
     * @Column(type="string", length=128, nullable=true)
     */
    protected $remark;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $updatetime;

    /**
     *
     * @var string
     * @Column(type="string", length=1024, nullable=true)
     */
    protected $data;

    /**
     * Method to set the value of field Id
     *
     * @param integer $Id
     * @return $this
     */
    public function setId($Id)
    {
        $this->id = $Id;

        return $this;
    }

    /**
     * Method to set the value of field User_id
     *
     * @param integer $User_id
     * @return $this
     */
    public function setUserId($User_id)
    {
        $this->user_id = $User_id;

        return $this;
    }

    /**
     * Method to set the value of field User_name
     *
     * @param string $User_name
     * @return $this
     */
    public function setUserName($User_name)
    {
        $this->user_name = $User_name;

        return $this;
    }

    /**
     * Method to set the value of field Controller
     *
     * @param string $Controller
     * @return $this
     */
    public function setController($Controller)
    {
        $this->controller = $Controller;

        return $this;
    }

    /**
     * Method to set the value of field Action
     *
     * @param string $Action
     * @return $this
     */
    public function setAction($Action)
    {
        $this->action = $Action;

        return $this;
    }

    /**
     * Method to set the value of field Remark
     *
     * @param string $Remark
     * @return $this
     */
    public function setRemark($Remark)
    {
        $this->remark = $Remark;

        return $this;
    }

    /**
     * Method to set the value of field Updatetime
     *
     * @param integer $Updatetime
     * @return $this
     */
    public function setUpdatetime($Updatetime)
    {
        $this->updateTime = $Updatetime;

        return $this;
    }

    /**
     * Method to set the value of field Data
     *
     * @param string $Data
     * @return $this
     */
    public function setData($Data)
    {
        $this->data = $Data;

        return $this;
    }

    /**
     * Returns the value of field Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field User_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field User_name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Returns the value of field Controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the value of field Action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the value of field Remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Returns the value of field Updatetime
     *
     * @return integer
     */
    public function getUpdatetime()
    {
        return $this->updateTime;
    }

    /**
     * Returns the value of field Data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('dblog');//不同的库
//        $this->setSchema("zeji_crm");
        $this->setSource("tb_sys_log");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_sys_log';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbSysLog[]|TbSysLog|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbSysLog|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
