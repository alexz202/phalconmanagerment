<?php

namespace Zejicrm\Modules\Frontend\Models;

class RoleScreen extends \Zejicrm\Models\Base
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
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $key;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $controller;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $show;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $create;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $edit;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $detail;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $role_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $update_time;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $gas;

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
     * Method to set the value of field Key
     *
     * @param string $Key
     * @return $this
     */
    public function setKey($Key)
    {
        $this->key = $Key;

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
     * Method to set the value of field Show
     *
     * @param integer $Show
     * @return $this
     */
    public function setShow($Show)
    {
        $this->show = $Show;

        return $this;
    }

    /**
     * Method to set the value of field Create
     *
     * @param integer $Create
     * @return $this
     */
    public function setCreate($Create)
    {
        $this->create = $Create;

        return $this;
    }

    /**
     * Method to set the value of field Edit
     *
     * @param integer $Edit
     * @return $this
     */
    public function setEdit($Edit)
    {
        $this->edit = $Edit;

        return $this;
    }

    /**
     * Method to set the value of field Detail
     *
     * @param integer $Detail
     * @return $this
     */
    public function setDetail($Detail)
    {
        $this->detail = $Detail;

        return $this;
    }

    /**
     * Method to set the value of field Role_id
     *
     * @param integer $Role_id
     * @return $this
     */
    public function setRoleId($Role_id)
    {
        $this->role_id = $Role_id;

        return $this;
    }

    /**
     * Method to set the value of field Update_time
     *
     * @param string $Update_time
     * @return $this
     */
    public function setUpdateTime($Update_time)
    {
        $this->update_time = $Update_time;

        return $this;
    }

    /**
     * Method to set the value of field Gas
     *
     * @param integer $Gas
     * @return $this
     */
    public function setGas($Gas)
    {
        $this->gas = $Gas;

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
     * Returns the value of field Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
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
     * Returns the value of field Show
     *
     * @return integer
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * Returns the value of field Create
     *
     * @return integer
     */
    public function getCreate()
    {
        return $this->create;
    }

    /**
     * Returns the value of field Edit
     *
     * @return integer
     */
    public function getEdit()
    {
        return $this->edit;
    }

    /**
     * Returns the value of field Detail
     *
     * @return integer
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Returns the value of field Role_id
     *
     * @return integer
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * Returns the value of field Update_time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * Returns the value of field Gas
     *
     * @return integer
     */
    public function getGas()
    {
        return $this->gas;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zeji_qa_admin");
        $this->setSource("tb_role_screen");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_role_screen';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbRoleScreen[]|TbRoleScreen|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbRoleScreen|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
