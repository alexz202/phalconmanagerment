<?php
namespace Zejicrm\Modules\Frontend\Models;

class Customer extends \Zejicrm\Models\Base
{
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $seed_id;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $customer_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=true)
     */
    protected $contact_info;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $city;

    /**
     *
     * @var string
     * @Column(type="string", length=128, nullable=true)
     */
    protected $comm_email;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
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
     * @Column(type="string", length=16, nullable=true)
     */
    protected $create_man;

    /**
     *
     * @var string
     * @Column(type="string", length=512, nullable=true)
     */
    protected $follow_result;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $follow_link_date;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $follow_num;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $customer_phase;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $customer_source;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $extend1;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $extend10;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $extend11;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $extend12;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $extend13;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $extend14;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $extend15;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $extend16;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $extend2;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $extend3;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $extend4;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $extend5;

    /**
     *
     * @var string
     * @Column(type="string", length=512, nullable=true)
     */
    protected $extend8;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $extend9;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $gender;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $industry_kind;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $introduce_customer_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $kind;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $mobile_phone;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $customer_state;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $own_date;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $province;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $qq;

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
    protected $cub_account_id;

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
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $update_flag;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $zipcode;

    /**
     *
     * @var integer
     * @Column(type="integer", length=6, nullable=true)
     */
    protected $country;

    /**
     *
     * @var integer
     * @Column(type="integer", length=2, nullable=true)
     */
    protected $customer_kind;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $assist_man;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $contact_seed;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $contact_name;


    protected $extend17;

    protected $extend22;

    protected $extend23;
    protected $extend24;

    protected $extend46;


    protected $extend47;

    protected $follow_last_id;
    protected $follow_next_time;

    protected $user_id;

    protected $is_delete;



    public function setIsDelete($is_delete)
    {
        $this->is_delete = $is_delete;

        return $this;
    }

    public function getIsDelete()
    {
        return $this->is_delete;
    }


    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
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
     * Method to set the value of field Customer_name
     *
     * @param string $Customer_name
     * @return $this
     */
    public function setCustomerName($Customer_name)
    {
        $this->customer_name = $Customer_name;

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
     * Method to set the value of field Contact_info
     *
     * @param string $Contact_info
     * @return $this
     */
    public function setContactInfo($Contact_info)
    {
        $this->contact_info = $Contact_info;

        return $this;
    }

    /**
     * Method to set the value of field City
     *
     * @param string $City
     * @return $this
     */
    public function setCity($City)
    {
        $this->city = $City;

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
     * Method to set the value of field Follow_result
     *
     * @param string $Follow_result
     * @return $this
     */
    public function setFollowResult($Follow_result)
    {
        $this->follow_result = $Follow_result;

        return $this;
    }

    /**
     * Method to set the value of field Follow_link_date
     *
     * @param string $Follow_link_date
     * @return $this
     */
    public function setFollowLinkDate($Follow_link_date)
    {
        $this->follow_link_date = $Follow_link_date;

        return $this;
    }

    /**
     * Method to set the value of field Follow_num
     *
     * @param integer $Follow_num
     * @return $this
     */
    public function setFollowNum($Follow_num)
    {
        $this->follow_num = $Follow_num;

        return $this;
    }

    /**
     * Method to set the value of field Customer_phase
     *
     * @param integer $Customer_phase
     * @return $this
     */
    public function setCustomerPhase($Customer_phase)
    {
        $this->customer_phase = $Customer_phase;

        return $this;
    }

    /**
     * Method to set the value of field Customer_source
     *
     * @param integer $Customer_source
     * @return $this
     */
    public function setCustomerSource($Customer_source)
    {
        $this->customer_source = $Customer_source;

        return $this;
    }

    /**
     * Method to set the value of field Extend1
     *
     * @param string $Extend1
     * @return $this
     */
    public function setExtend1($Extend1)
    {
        $this->extend1 = $Extend1;

        return $this;
    }

    /**
     * Method to set the value of field Extend10
     *
     * @param string $Extend10
     * @return $this
     */
    public function setExtend10($Extend10)
    {
        $this->extend10 = $Extend10;

        return $this;
    }

    /**
     * Method to set the value of field Extend11
     *
     * @param string $Extend11
     * @return $this
     */
    public function setExtend11($Extend11)
    {
        $this->extend11 = $Extend11;

        return $this;
    }

    /**
     * Method to set the value of field Extend12
     *
     * @param string $Extend12
     * @return $this
     */
    public function setExtend12($Extend12)
    {
        $this->extend12 = $Extend12;

        return $this;
    }

    /**
     * Method to set the value of field Extend13
     *
     * @param string $Extend13
     * @return $this
     */
    public function setExtend13($Extend13)
    {
        $this->extend13 = $Extend13;

        return $this;
    }

    /**
     * Method to set the value of field Extend14
     *
     * @param string $Extend14
     * @return $this
     */
    public function setExtend14($Extend14)
    {
        $this->extend14 = $Extend14;

        return $this;
    }

    /**
     * Method to set the value of field Extend15
     *
     * @param string $Extend15
     * @return $this
     */
    public function setExtend15($Extend15)
    {
        $this->extend15 = $Extend15;

        return $this;
    }

    /**
     * Method to set the value of field Extend16
     *
     * @param string $Extend16
     * @return $this
     */
    public function setExtend16($Extend16)
    {
        $this->extend16 = $Extend16;

        return $this;
    }

    /**
     * Method to set the value of field Extend2
     *
     * @param string $Extend2
     * @return $this
     */
    public function setExtend2($Extend2)
    {
        $this->extend2 = $Extend2;

        return $this;
    }

    /**
     * Method to set the value of field Extend3
     *
     * @param string $Extend3
     * @return $this
     */
    public function setExtend3($Extend3)
    {
        $this->extend3 = $Extend3;

        return $this;
    }

    /**
     * Method to set the value of field Extend4
     *
     * @param string $Extend4
     * @return $this
     */
    public function setExtend4($Extend4)
    {
        $this->extend4 = $Extend4;

        return $this;
    }

    /**
     * Method to set the value of field Extend5
     *
     * @param string $Extend5
     * @return $this
     */
    public function setExtend5($Extend5)
    {
        $this->extend5 = $Extend5;

        return $this;
    }

    /**
     * Method to set the value of field Extend8
     *
     * @param string $Extend8
     * @return $this
     */
    public function setExtend8($Extend8)
    {
        $this->extend8 = $Extend8;

        return $this;
    }

    /**
     * Method to set the value of field Extend9
     *
     * @param string $Extend9
     * @return $this
     */
    public function setExtend9($Extend9)
    {
        $this->extend9 = $Extend9;

        return $this;
    }


    public function setExtend17($Extend17)
    {
        $this->extend17 = $Extend17;

        return $this;
    }


    public function setExtend22($Extend22)
    {
        $this->extend22 = $Extend22;

        return $this;
    }


    public function setExtend23($Extend23)
    {
        $this->extend23 = $Extend23;

        return $this;
    }

    public function setExtend24($Extend24)
    {
        $this->extend24 = $Extend24;

        return $this;
    }


    public function setExtend46($Extend46)
    {
        $this->extend46 = $Extend46;

        return $this;
    }

    public function setExtend47($Extend47)
    {
        $this->extend47 = $Extend47;

        return $this;
    }


    /**
     * Method to set the value of field Gender
     *
     * @param integer $Gender
     * @return $this
     */
    public function setGender($Gender)
    {
        $this->gender = $Gender;

        return $this;
    }

    /**
     * Method to set the value of field Industry_kind
     *
     * @param string $Industry_kind
     * @return $this
     */
    public function setIndustryKind($Industry_kind)
    {
        $this->industry_kind = $Industry_kind;

        return $this;
    }

    /**
     * Method to set the value of field Introduce_customer_name
     *
     * @param string $Introduce_customer_name
     * @return $this
     */
    public function setIntroduceCustomerName($Introduce_customer_name)
    {
        $this->introduce_customer_name = $Introduce_customer_name;

        return $this;
    }

    /**
     * Method to set the value of field Kind
     *
     * @param integer $Kind
     * @return $this
     */
    public function setKind($Kind)
    {
        $this->kind = $Kind;

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
     * Method to set the value of field Customer_state
     *
     * @param integer $Customer_state
     * @return $this
     */
    public function setCustomerState($Customer_state)
    {
        $this->customer_state = $Customer_state;

        return $this;
    }

    /**
     * Method to set the value of field Own_date
     *
     * @param string $Own_date
     * @return $this
     */
    public function setOwnDate($Own_date)
    {
        $this->own_date = $Own_date;

        return $this;
    }

    /**
     * Method to set the value of field Province
     *
     * @param string $Province
     * @return $this
     */
    public function setProvince($Province)
    {
        $this->province = $Province;

        return $this;
    }

    /**
     * Method to set the value of field Qq
     *
     * @param string $Qq
     * @return $this
     */
    public function setQq($Qq)
    {
        $this->qq = $Qq;

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
     * Method to set the value of field Update_flag
     *
     * @param string $Update_flag
     * @return $this
     */
    public function setUpdateFlag($Update_flag)
    {
        $this->update_flag = $Update_flag;

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

    /**
     * Method to set the value of field Country
     *
     * @param integer $Country
     * @return $this
     */
    public function setCountry($Country)
    {
        $this->country = $Country;

        return $this;
    }

    /**
     * Method to set the value of field Customer_kind
     *
     * @param integer $Customer_kind
     * @return $this
     */
    public function setCustomerKind($Customer_kind)
    {
        $this->customer_kind = $Customer_kind;

        return $this;
    }

    /**
     * Method to set the value of field Assist_man
     *
     * @param string $Assist_man
     * @return $this
     */
    public function setAssistMan($Assist_man)
    {
        $this->assist_man = $Assist_man;

        return $this;
    }

    /**
     * Method to set the value of field Contact_seed
     *
     * @param integer $Contact_seed
     * @return $this
     */
    public function setContactSeed($Contact_seed)
    {
        $this->contact_seed = $Contact_seed;

        return $this;
    }

    /**
     * Method to set the value of field Contact_name
     *
     * @param string $Contact_name
     * @return $this
     */
    public function setContactName($Contact_name)
    {
        $this->contact_name = $Contact_name;

        return $this;
    }


    public function setFollowLastId($followLastId)
    {
        $this->follow_last_id = $followLastId;

        return $this;
    }

    public function setFollowNextTime($followNextTime)
    {
        $this->follow_next_time = $followNextTime;
        return $this;
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
     * Returns the value of field Customer_name
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customer_name;
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
     * Returns the value of field Contact_info
     *
     * @return string
     */
    public function getContactInfo()
    {
        return $this->contact_info;
    }

    /**
     * Returns the value of field City
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
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
     * Returns the value of field Follow_result
     *
     * @return string
     *
     *
     */
    public function getFollowResult()
    {
        return $this->follow_result;
    }

    /**
     * Returns the value of field Follow_link_date
     *
     * @return string
     */
    public function getFollowLinkDate()
    {
        return $this->follow_link_date;
    }

    /**
     * Returns the value of field Follow_num
     *
     * @return integer
     */
    public function getFollowNum()
    {
        return $this->follow_num;
    }

    /**
     * Returns the value of field Customer_phase
     *
     * @return integer
     */
    public function getCustomerPhase()
    {
        return $this->customer_phase;
    }

    /**
     * Returns the value of field Customer_source
     *
     * @return integer
     */
    public function getCustomerSource()
    {
        return $this->customer_source;
    }

    /**
     * Returns the value of field Extend1
     *
     * @return string
     */
    public function getExtend1()
    {
        return $this->extend1;
    }

    /**
     * Returns the value of field Extend10
     *
     * @return string
     */
    public function getExtend10()
    {
        return $this->extend10;
    }

    /**
     * Returns the value of field Extend11
     *
     * @return string
     */
    public function getExtend11()
    {
        return $this->extend11;
    }

    /**
     * Returns the value of field Extend12
     *
     * @return string
     */
    public function getExtend12()
    {
        return $this->extend12;
    }

    /**
     * Returns the value of field Extend13
     *
     * @return string
     */
    public function getExtend13()
    {
        return $this->extend13;
    }

    /**
     * Returns the value of field Extend14
     *
     * @return string
     */
    public function getExtend14()
    {
        return $this->extend14;
    }

    /**
     * Returns the value of field Extend15
     *
     * @return string
     */
    public function getExtend15()
    {
        return $this->extend15;
    }

    /**
     * Returns the value of field Extend16
     *
     * @return string
     */
    public function getExtend16()
    {
        return $this->extend16;
    }

    /**
     * Returns the value of field Extend2
     *
     * @return string
     */
    public function getExtend2()
    {
        return $this->extend2;
    }

    /**
     * Returns the value of field Extend3
     *
     * @return string
     */
    public function getExtend3()
    {
        return $this->extend3;
    }

    /**
     * Returns the value of field Extend4
     *
     * @return string
     */
    public function getExtend4()
    {
        return $this->extend4;
    }

    /**
     * Returns the value of field Extend5
     *
     * @return string
     */
    public function getExtend5()
    {
        return $this->extend5;
    }

    /**
     * Returns the value of field Extend8
     *
     * @return string
     */
    public function getExtend8()
    {
        return $this->extend8;
    }

    /**
     * Returns the value of field Extend9
     *
     * @return string
     */
    public function getExtend9()
    {
        return $this->extend9;
    }



    public function getExtend17()
    {
        return $this->extend17;
    }



    public function getExtend22()
    {
        return $this->extend22;
    }


    public function getExtend23()
    {
        return $this->extend23;
    }



    public function getExtend24()
    {
        return $this->extend24;
    }


    public function getExtend46()
    {
        return $this->extend46;
    }

    public function getExtend47()
    {
        return $this->extend47;
    }

    /**
     * Returns the value of field Gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Returns the value of field Industry_kind
     *
     * @return string
     */
    public function getIndustryKind()
    {
        return $this->industry_kind;
    }

    /**
     * Returns the value of field Introduce_customer_name
     *
     * @return string
     */
    public function getIntroduceCustomerName()
    {
        return $this->introduce_customer_name;
    }

    /**
     * Returns the value of field Kind
     *
     * @return integer
     */
    public function getKind()
    {
        return $this->kind;
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
     * Returns the value of field Customer_state
     *
     * @return integer
     */
    public function getCustomerState()
    {
        return $this->customer_state;
    }

    /**
     * Returns the value of field Own_date
     *
     * @return string
     */
    public function getOwnDate()
    {
        return $this->own_date;
    }

    /**
     * Returns the value of field Province
     *
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Returns the value of field Qq
     *
     * @return string
     */
    public function getQq()
    {
        return $this->qq;
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
     * Returns the value of field Update_flag
     *
     * @return string
     */
    public function getUpdateFlag()
    {
        return $this->update_flag;
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
     * Returns the value of field Country
     *
     * @return integer
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Returns the value of field Customer_kind
     *
     * @return integer
     */
    public function getCustomerKind()
    {
        return $this->customer_kind;
    }

    /**
     * Returns the value of field Assist_man
     *
     * @return string
     */
    public function getAssistMan()
    {
        return $this->assist_man;
    }

    /**
     * Returns the value of field Contact_seed
     *
     * @return integer
     */
    public function getContactSeed()
    {
        return $this->contact_seed;
    }

    /**
     * Returns the value of field Contact_name
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contact_name;
    }

    public function getFollowLastId()
    {
        return $this->follow_last_id;
    }

    public function getFollowNextTime()
    {
        return $this->follow_next_time;
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zeji_crm");
        $this->setSource("tb_customer");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_customer';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbCustomer[]|TbCustomer|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbCustomer|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }




    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
//    public function columnMap()
//    {
//        return [
//            'seed_id' => 'seed_id',
//            'customer_name' => 'customer_name',
//            'address' => 'address',
//            'contact_info' => 'contact_info',
//            'city' => 'city',
//            'comm_email' => 'comm_email',
//            'comm_phone' => 'comm_phone',
//            'create_date' => 'create_date',
//            'create_man' => 'create_man',
//            'follow_result' => 'follow_result',
//            'follow_link_date' => 'follow_link_date',
//            'follow_num' => 'follow_num',
//            'customer_phase' => 'customer_phase',
//            'customer_source' => 'customer_source',
//            'extend1' => 'extend1',
//            'extend10' => 'extend10',
//            'extend11' => 'extend11',
//            'extend12' => 'extend12',
//            'extend13' => 'extend13',
//            'extend14' => 'extend14',
//            'extend15' => 'extend15',
//            'extend16' => 'extend16',
//            'extend2' => 'extend2',
//            'extend3' => 'extend3',
//            'extend4' => 'extend4',
//            'extend5' => 'extend5',
//            'extend8' => 'extend8',
//            'extend9' => 'extend9',
//            'gender' => 'gender',
//            'industry_kind' => 'industry_kind',
//            'introduce_customer_name' => 'introduce_customer_name',
//            'kind' => 'kind',
//            'mobile_phone' => 'mobile_phone',
//            'customer_state' => 'customer_state',
//            'own_date' => 'own_date',
//            'province' => 'province',
//            'qq' => 'qq',
//            'remark' => 'remark',
//            'sub_account_id' => 'sub_account_id',
//            'update_date' => 'update_date',
//            'update_man' => 'update_man',
//            'update_flag' => 'update_flag',
//            'zipcode' => 'zipcode',
//            'country' => 'country',
//            'customer_kind' => 'customer_kind',
//            'assist_man' => 'assist_man',
//            'contact_seed' => 'contact_seed',
//            'contact_name' => 'contact_name'
//        ];
//    }

}
