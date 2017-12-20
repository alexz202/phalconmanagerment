<?php

namespace Zejicrm\Modules\Frontend\Models;

class CustomerRemark extends \Zejicrm\Models\Base
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $seed_id;

    /**
     *
     * @var string
     * @Column(type="string", length=512, nullable=true)
     */
    protected $remark;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $update_time;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $create_time;

    /**
     * Method to set the value of field Id
     *
     * @param integer $Id
     * @return $this
     */
    protected $user_id;

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserId()
    {
        return $this->user_id ;
    }

    public function setId($Id)
    {
        $this->id = $Id;

        return $this;
    }

    /**
     * Method to set the value of field Seed_id
     *
     * @param integer $Seed_id
     * @return $this
     */
    public function setSeedId($Seed_id)
    {
        $this->seed_id = $Seed_id;

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
     * Method to set the value of field Update_time
     *
     * @param integer $Update_time
     * @return $this
     */
    public function setUpdateTime($Update_time)
    {
        $this->update_time = $Update_time;

        return $this;
    }

    /**
     * Method to set the value of field Create_time
     *
     * @param integer $Create_time
     * @return $this
     */
    public function setCreateTime($Create_time)
    {
        $this->create_time = $Create_time;

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
     * Returns the value of field Seed_id
     *
     * @return integer
     */
    public function getSeedId()
    {
        return $this->seed_id;
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
     * Returns the value of field Update_time
     *
     * @return integer
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * Returns the value of field Create_time
     *
     * @return integer
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zeji_crm");
        $this->setSource("tb_customer_remark");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_customer_remark';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbCustomerRemark[]|TbCustomerRemark|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbCustomerRemark|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
