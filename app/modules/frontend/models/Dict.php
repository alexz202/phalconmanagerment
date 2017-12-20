<?php

namespace Zejicrm\Modules\Frontend\Models;

class Dict extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=8, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $key;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $value;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $type;

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
     * Method to set the value of field Value
     *
     * @param string $Value
     * @return $this
     */
    public function setValue($Value)
    {
        $this->value = $Value;

        return $this;
    }

    /**
     * Method to set the value of field Type
     *
     * @param integer $Type
     * @return $this
     */
    public function setType($Type)
    {
        $this->type = $Type;

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
     * Returns the value of field Value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the value of field Type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zeji_qa_admin");
        $this->setSource("tb_dict");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_dict';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbDict[]|TbDict|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbDict|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
