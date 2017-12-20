<?php

namespace Zejicrm\Modules\Frontend\Models;

class User extends \Zejicrm\Models\Base
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     *
     * @var string
     * @Column(type="string", length=128, nullable=true)
     */
    protected $comm_email;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $comm_fax;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $comm_phone;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $create_date;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $create_man;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $dead_line;

    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    protected $dept;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $password;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $is_duty_sales;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $is_duty_service_staff;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $is_login_allow;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $last_log_time;

    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    protected $log_times;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $mobile_phone;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $parent_staff_seed;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $position;

    /**
     *
     * @var string
     * @Column(type="string", length=512, nullable=true)
     */
    protected $remark;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $seat_phone;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $staff_alias;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $staff_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $state;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $sub_account_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $update_date;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $update_man;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $user_role;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $zipcode;

    protected $group_leader_id;

    protected $is_leader;

    protected $level;

    protected $sales_level;

    protected $is_delete;

    public function setGroupLeaderId($group_leader_id)
    {
        $this->group_leader_id = $group_leader_id;

        return $this;
    }


    public function setIsLeader($is_leader)
    {
        $this->is_leader = $is_leader;

        return $this;
    }

    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    public function setSalesLevel($sales_level)
    {
        $this->sales_level = $sales_level;

        return $this;
    }



    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Method to set the value of field Userid
     *
     * @param integer $Userid
     * @return $this
     */
    public function setUserid($Userid)
    {
        $this->user_id = $Userid;

        return $this;
    }

    /**
     * Method to set the value of field Address
     *
     * @param string $Address
     * @return $this
     */
    public function setAddress($Address)
    {
        $this->address = $Address;

        return $this;
    }

    /**
     * Method to set the value of field Comm_email
     *
     * @param string $Comm_email
     * @return $this
     */
    public function setCommEmail($Comm_email)
    {
        $this->comm_email = $Comm_email;

        return $this;
    }

    /**
     * Method to set the value of field Comm_fax
     *
     * @param string $Comm_fax
     * @return $this
     */
    public function setCommFax($Comm_fax)
    {
        $this->comm_fax = $Comm_fax;

        return $this;
    }

    /**
     * Method to set the value of field Comm_phone
     *
     * @param string $Comm_phone
     * @return $this
     */
    public function setCommPhone($Comm_phone)
    {
        $this->comm_phone = $Comm_phone;

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
     * Method to set the value of field Create_man
     *
     * @param string $Create_man
     * @return $this
     */
    public function setCreateMan($Create_man)
    {
        $this->create_man = $Create_man;

        return $this;
    }

    /**
     * Method to set the value of field Dead_line
     *
     * @param string $Dead_line
     * @return $this
     */
    public function setDeadLine($Dead_line)
    {
        $this->dead_line = $Dead_line;

        return $this;
    }

    /**
     * Method to set the value of field Dept
     *
     * @param integer $Dept
     * @return $this
     */
    public function setDept($Dept)
    {
        $this->dept = $Dept;

        return $this;
    }

    /**
     * Method to set the value of field Password
     *
     * @param string $Password
     * @return $this
     */
    public function setPassword($Password)
    {
        $this->password = $Password;

        return $this;
    }

    /**
     * Method to set the value of field Is_duty_sales
     *
     * @param integer $Is_duty_sales
     * @return $this
     */
    public function setIsDutySales($Is_duty_sales)
    {
        $this->is_duty_sales = $Is_duty_sales;

        return $this;
    }

    /**
     * Method to set the value of field Is_duty_service_staff
     *
     * @param integer $Is_duty_service_staff
     * @return $this
     */
    public function setIsDutyServiceStaff($Is_duty_service_staff)
    {
        $this->is_duty_service_staff = $Is_duty_service_staff;

        return $this;
    }

    /**
     * Method to set the value of field Is_login_allow
     *
     * @param integer $Is_login_allow
     * @return $this
     */
    public function setIsLoginAllow($Is_login_allow)
    {
        $this->is_login_allow = $Is_login_allow;

        return $this;
    }

    /**
     * Method to set the value of field Last_log_time
     *
     * @param string $Last_log_time
     * @return $this
     */
    public function setLastLogTime($Last_log_time)
    {
        $this->last_log_time = $Last_log_time;

        return $this;
    }

    /**
     * Method to set the value of field Log_times
     *
     * @param integer $Log_times
     * @return $this
     */
    public function setLogTimes($Log_times)
    {
        $this->log_times = $Log_times;

        return $this;
    }

    /**
     * Method to set the value of field Mobile_phone
     *
     * @param string $Mobile_phone
     * @return $this
     */
    public function setMobilePhone($Mobile_phone)
    {
        $this->mobile_phone = $Mobile_phone;

        return $this;
    }

    /**
     * Method to set the value of field Parent_staff_seed
     *
     * @param integer $Parent_staff_seed
     * @return $this
     */
    public function setParentStaffSeed($Parent_staff_seed)
    {
        $this->parent_staff_seed = $Parent_staff_seed;

        return $this;
    }

    /**
     * Method to set the value of field Position
     *
     * @param string $Position
     * @return $this
     */
    public function setPosition($Position)
    {
        $this->position = $Position;

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
     * Method to set the value of field Seat_phone
     *
     * @param string $Seat_phone
     * @return $this
     */
    public function setSeatPhone($Seat_phone)
    {
        $this->seat_phone = $Seat_phone;

        return $this;
    }

    /**
     * Method to set the value of field Staff_alias
     *
     * @param string $Staff_alias
     * @return $this
     */
    public function setStaffAlias($Staff_alias)
    {
        $this->staff_alias = $Staff_alias;

        return $this;
    }

    /**
     * Method to set the value of field Staff_name
     *
     * @param string $Staff_name
     * @return $this
     */
    public function setStaffName($Staff_name)
    {
        $this->staff_name = $Staff_name;

        return $this;
    }

    /**
     * Method to set the value of field State
     *
     * @param integer $State
     * @return $this
     */
    public function setState($State)
    {
        $this->state = $State;

        return $this;
    }

    /**
     * Method to set the value of field Sub_account_id
     *
     * @param string $Sub_account_id
     * @return $this
     */
    public function setSubAccountId($Sub_account_id)
    {
        $this->sub_account_id = $Sub_account_id;

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
     * Method to set the value of field Update_man
     *
     * @param string $Update_man
     * @return $this
     */
    public function setUpdateMan($Update_man)
    {
        $this->update_man = $Update_man;

        return $this;
    }

    /**
     * Method to set the value of field User_role
     *
     * @param integer $User_role
     * @return $this
     */
    public function setUserRole($User_role)
    {
        $this->user_role = $User_role;

        return $this;
    }

    /**
     * Method to set the value of field Zipcode
     *
     * @param string $Zipcode
     * @return $this
     */
    public function setZipcode($Zipcode)
    {
        $this->zipcode = $Zipcode;

        return $this;
    }


    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }


    public function getIsDelete()
    {
        return $this->is_delete ;
    }


    public function getGroupLeaderId()
    {
      return   $this->group_leader_id ;

    }


    public function getIsLeader()
    {
        return $this->is_leader ;

    }

    public function getLevel()
    {
       return  $this->level ;
    }

    public function getSalesLevel()
    {
        return  $this->sales_level ;
    }

    /**
     * Returns the value of field Userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field Address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Returns the value of field Comm_email
     *
     * @return string
     */
    public function getCommEmail()
    {
        return $this->comm_email;
    }

    /**
     * Returns the value of field Comm_fax
     *
     * @return string
     */
    public function getCommFax()
    {
        return $this->comm_fax;
    }

    /**
     * Returns the value of field Comm_phone
     *
     * @return string
     */
    public function getCommPhone()
    {
        return $this->comm_phone;
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
     * Returns the value of field Create_man
     *
     * @return string
     */
    public function getCreateMan()
    {
        return $this->create_man;
    }

    /**
     * Returns the value of field Dead_line
     *
     * @return string
     */
    public function getDeadLine()
    {
        return $this->dead_line;
    }

    /**
     * Returns the value of field Dept
     *
     * @return integer
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     * Returns the value of field Password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field Is_duty_sales
     *
     * @return integer
     */
    public function getIsDutySales()
    {
        return $this->is_duty_sales;
    }

    /**
     * Returns the value of field Is_duty_service_staff
     *
     * @return integer
     */
    public function getIsDutyServiceStaff()
    {
        return $this->is_duty_service_staff;
    }

    /**
     * Returns the value of field Is_login_allow
     *
     * @return integer
     */
    public function getIsLoginAllow()
    {
        return $this->is_login_allow;
    }

    /**
     * Returns the value of field Last_log_time
     *
     * @return string
     */
    public function getLastLogTime()
    {
        return $this->last_log_time;
    }

    /**
     * Returns the value of field Log_times
     *
     * @return integer
     */
    public function getLogTimes()
    {
        return $this->log_times;
    }

    /**
     * Returns the value of field Mobile_phone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobile_phone;
    }

    /**
     * Returns the value of field Parent_staff_seed
     *
     * @return integer
     */
    public function getParentStaffSeed()
    {
        return $this->parent_staff_seed;
    }

    /**
     * Returns the value of field Position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
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
     * Returns the value of field Seat_phone
     *
     * @return string
     */
    public function getSeatPhone()
    {
        return $this->seat_phone;
    }

    /**
     * Returns the value of field Staff_alias
     *
     * @return string
     */
    public function getStaffAlias()
    {
        return $this->staff_alias;
    }

    /**
     * Returns the value of field Staff_name
     *
     * @return string
     */
    public function getStaffName()
    {
        return $this->staff_name;
    }

    /**
     * Returns the value of field State
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Returns the value of field Sub_account_id
     *
     * @return string
     */
    public function getSubAccountId()
    {
        return $this->sub_account_id;
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
     * Returns the value of field Update_man
     *
     * @return string
     */
    public function getUpdateMan()
    {
        return $this->update_man;
    }

    /**
     * Returns the value of field User_role
     *
     * @return integer
     */
    public function getUserRole()
    {
        return $this->user_role;
    }

    /**
     * Returns the value of field Zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
      //  $this->setConnectionService('dbadmin');
        $this->setSchema("zeji_qa_admin");
        $this->setSource("tb_user");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
