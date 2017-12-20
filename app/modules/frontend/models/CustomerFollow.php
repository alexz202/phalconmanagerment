<?php

namespace Zejicrm\Modules\Frontend\Models;

class CustomerFollow extends \Zejicrm\Models\Base
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
     * @Column(type="string", length=256, nullable=true)
     */
    protected $action_subject;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $after_kind;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $before_phase;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $customer_kind;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $customer_name;

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
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $customer_phase;

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
    protected $link_date;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $link_kind;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $next_date;

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
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $customer_seed_id;

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

    /**
     * Method to set the value of field Id
     *
     * @param integer $Id
     * @return $this
     */

    protected $user_id;

    protected $customer_source;

    public function setCustomerSource($customer_source)
    {
        $this->customer_source = $customer_source;
        return $this;
    }



    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }


    public function getCustomerSource()
    {
        return $this->customer_source;
    }


    public function getUserId()
    {
        return $this->user_id;
    }

    public function setId($Id)
    {
        $this->id = $Id;
        return $this;
    }

    /**
     * Method to set the value of field Action_subject
     *
     * @param string $Action_subject
     * @return $this
     */
    public function setActionSubject($Action_subject)
    {
        $this->action_subject = $Action_subject;

        return $this;
    }

    /**
     * Method to set the value of field After_kind
     *
     * @param integer $After_kind
     * @return $this
     */
    public function setAfterKind($After_kind)
    {
        $this->after_kind = $After_kind;

        return $this;
    }

    /**
     * Method to set the value of field Before_phase
     *
     * @param integer $Before_phase
     * @return $this
     */
    public function setBeforePhase($Before_phase)
    {
        $this->before_phase = $Before_phase;

        return $this;
    }

    /**
     * Method to set the value of field Change_customer_kind
     *
     * @param integer $Change_customer_kind
     * @return $this
     */
    public function setCustomerKind($customer_kind)
    {
        $this->customer_kind = $customer_kind;

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
     * Method to set the value of field Link_date
     *
     * @param string $Link_date
     * @return $this
     */
    public function setLinkDate($Link_date)
    {
        $this->link_date = $Link_date;

        return $this;
    }

    /**
     * Method to set the value of field Link_kind
     *
     * @param integer $Link_kind
     * @return $this
     */
    public function setLinkKind($Link_kind)
    {
        $this->link_kind = $Link_kind;

        return $this;
    }

    /**
     * Method to set the value of field Next_date
     *
     * @param string $Next_date
     * @return $this
     */
    public function setNextDate($Next_date)
    {
        $this->next_date = $Next_date;

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
     * Method to set the value of field Customer_seed_id
     *
     * @param integer $Customer_seed_id
     * @return $this
     */
    public function setCustomerSeedId($Customer_seed_id)
    {
        $this->customer_seed_id = $Customer_seed_id;

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
     * Returns the value of field Action_subject
     *
     * @return string
     */
    public function getActionSubject()
    {
        return $this->action_subject;
    }

    /**
     * Returns the value of field After_kind
     *
     * @return integer
     */
    public function getAfterKind()
    {
        return $this->after_kind;
    }

    /**
     * Returns the value of field Before_phase
     *
     * @return integer
     */
    public function getBeforePhase()
    {
        return $this->before_phase;
    }

    /**
     * Returns the value of field Change_customer_kind
     *
     * @return integer
     */
    public function getCustomerKind()
    {
        return $this->customer_kind;
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
     * Returns the value of field Customer_phase
     *
     * @return integer
     */
    public function getCustomerPhase()
    {
        return $this->customer_phase;
    }

    /**
     * Returns the value of field Follow_result
     *
     * @return string
     */
    public function getFollowResult()
    {
        return $this->follow_result;
    }

    /**
     * Returns the value of field Link_date
     *
     * @return string
     */
    public function getLinkDate()
    {
        return $this->link_date;
    }

    /**
     * Returns the value of field Link_kind
     *
     * @return integer
     */
    public function getLinkKind()
    {
        return $this->link_kind;
    }

    /**
     * Returns the value of field Next_date
     *
     * @return string
     */
    public function getNextDate()
    {
        return $this->next_date;
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
     * Returns the value of field Customer_seed_id
     *
     * @return integer
     */
    public function getCustomerSeedId()
    {
        return $this->customer_seed_id;
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

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zeji_crm");
        $this->setSource("tb_customer_follow");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_customer_follow';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbCustomerFollow[]|TbCustomerFollow|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbCustomerFollow|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
