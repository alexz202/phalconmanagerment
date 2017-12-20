<?php

namespace Zejicrm\Modules\Frontend\Models;

class ColumnsIndex extends \Zejicrm\Models\Base
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
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $key;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    protected $type;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $ispk;

    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $lable;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $show;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $create;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $edit;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $detail;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $search;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $gassearch;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $orderby;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $tag;

    /**
     *
     * @var integer
     * @Column(type="integer", length=3, nullable=true)
     */
    protected $required;

    /**
     *
     * @var integer
     * @Column(type="integer", length=8, nullable=true)
     */
    protected $sort;

    /**
     *
     * @var string
     * @Column(type="string", length=512, nullable=true)
     */
    protected $searchOptions;

    /**
     *
     * @var string
     * @Column(type="string", length=512, nullable=true)
     */
    protected $gssearchOptions;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $controller;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=true)
     */
    protected $action;


    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=true)
     */
    protected $width;


    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=true)
     */
    protected $class;

    protected $extra;


    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }


    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }



    public function getExtra()
    {
        return $this->extra;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getClass()
    {
       return  $this->class;

    }







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
     * Method to set the value of field Ispk
     *
     * @param integer $Ispk
     * @return $this
     */
    public function setIspk($Ispk)
    {
        $this->ispk = $Ispk;

        return $this;
    }

    /**
     * Method to set the value of field Lable
     *
     * @param string $Lable
     * @return $this
     */
    public function setLable($Lable)
    {
        $this->lable = $Lable;

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
     * Method to set the value of field Search
     *
     * @param integer $Search
     * @return $this
     */
    public function setSearch($Search)
    {
        $this->search = $Search;

        return $this;
    }

    /**
     * Method to set the value of field Gassearch
     *
     * @param integer $Gassearch
     * @return $this
     */
    public function setGassearch($Gassearch)
    {
        $this->gassearch = $Gassearch;

        return $this;
    }

    /**
     * Method to set the value of field Orderby
     *
     * @param integer $Orderby
     * @return $this
     */
    public function setOrderby($Orderby)
    {
        $this->crderby = $Orderby;

        return $this;
    }

    /**
     * Method to set the value of field Tag
     *
     * @param integer $Tag
     * @return $this
     */
    public function setTag($Tag)
    {
        $this->tag = $Tag;

        return $this;
    }

    /**
     * Method to set the value of field Required
     *
     * @param integer $Required
     * @return $this
     */
    public function setRequired($Required)
    {
        $this->required = $Required;

        return $this;
    }

    /**
     * Method to set the value of field Sort
     *
     * @param integer $Sort
     * @return $this
     */
    public function setSort($Sort)
    {
        $this->sort = $Sort;

        return $this;
    }

    /**
     * Method to set the value of field Searchoptions
     *
     * @param string $Searchoptions
     * @return $this
     */
    public function setSearchoptions($Searchoptions)
    {
        $this->searchOptions = $Searchoptions;

        return $this;
    }

    /**
     * Method to set the value of field Gssearchoptions
     *
     * @param string $Gssearchoptions
     * @return $this
     */
    public function setGssearchoptions($Gssearchoptions)
    {
        $this->gssearchOptions = $Gssearchoptions;

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
     * Returns the value of field Type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the value of field Ispk
     *
     * @return integer
     */
    public function getIspk()
    {
        return $this->ispk;
    }

    /**
     * Returns the value of field Lable
     *
     * @return string
     */
    public function getLable()
    {
        return $this->lable;
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
     * Returns the value of field Search
     *
     * @return integer
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Returns the value of field Gassearch
     *
     * @return integer
     */
    public function getGassearch()
    {
        return $this->gassearch;
    }

    /**
     * Returns the value of field Orderby
     *
     * @return integer
     */
    public function getOrderby()
    {
        return $this->orderby;
    }

    /**
     * Returns the value of field Tag
     *
     * @return integer
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Returns the value of field Required
     *
     * @return integer
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Returns the value of field Sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Returns the value of field Searchoptions
     *
     * @return string
     */
    public function getSearchoptions()
    {
        return $this->searchOptions;
    }

    /**
     * Returns the value of field Gssearchoptions
     *
     * @return string
     */
    public function getGssearchoptions()
    {
        return $this->gssearchOptions;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("zeji_qa_admin");
        $this->setSource("tb_columns_index");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbColumnsIndex[]|TbColumnsIndex|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TbColumnsIndex|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_columns_index';
    }

}
