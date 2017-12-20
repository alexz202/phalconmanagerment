<?php

namespace Zejicrm\Modules\Frontend\Models;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

class Role extends \Phalcon\Mvc\Model
{

    public function validation()
    {
        $validator = new Validation();


        $validator->add(
            'role',
            new Uniqueness(
                [
                    'message' => 'The role name must be unique',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=8, nullable=false)
     */
    protected $role_id;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $role_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $remark;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $create_date;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $update_date;

    /**
     *
     * @var string
     * @Column(type="string", length=1024, nullable=true)
     */
    protected $role_acl;

    /**
     * Method to set the value of field Role_id
     *
     * @param integer $Role_id
     * @return $this
     */

    protected $role;

    protected $data_level;

    protected $s_data_group_id;





    public function setRole($role){
        $this->role=$role;
    }

    public function setRoleId($Role_id)
    {
        $this->role_id = $Role_id;

        return $this;
    }

    /**
     * Method to set the value of field Role_name
     *
     * @param string $Role_name
     * @return $this
     */
    public function setRoleName($Role_name)
    {
        $this->role_name = $Role_name;

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
     * Method to set the value of field Create_date
     *
     * @param string $Create_date
     * @return $this
     */
    public function setCreateDate($Create_date)
    {
        $this->create_date = $Create_date;

        return $this;
    }

    /**
     * Method to set the value of field Update_date
     *
     * @param string $Update_date
     * @return $this
     */
    public function setUpdateDate($Update_date)
    {
        $this->update_date = $Update_date;

        return $this;
    }

    /**
     * Method to set the value of field Role_acl
     *
     * @param string $Role_acl
     * @return $this
     */
    public function setRoleAcl($Role_acl)
    {
        $this->role_acl = $Role_acl;

        return $this;
    }


    /*
     * 数据等级
     */
    public function setDataLevel($dataLevel){
        $this->data_level=$dataLevel;
    }

    public function getDataLevel(){
        return  $this->data_level;
    }

    /*
     * 特殊条件
     */
    public function setSDataGroupId($sDataGroupId){
        $this->s_data_group_id=$sDataGroupId;
    }

    public function getSDataGroupId(){
        return  $this->s_data_group_id;
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
     * Returns the value of field Role_name
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->role_name;
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
     * Returns the value of field Create_date
     *
     * @return string
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Returns the value of field Update_date
     *
     * @return string
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * Returns the value of field Role_acl
     *
     * @return string
     */
    public function getRoleAcl()
    {
        return $this->role_acl;
    }

    public function getRole()
    {
        return $this->role;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zeji_qa_admin");
        $this->setSource("tb_role");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_role';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Role[]|Role|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Role|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }



}
