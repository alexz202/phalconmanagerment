<?php
namespace Zejicrm\Modules\Frontend\Models;

use Phalcon\Mvc\Model\Query as QueryInfo;

class Resource extends \Phalcon\Mvc\Model
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
     * @Column(type="string", length=255, nullable=true)
     */
    protected $remark;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $createTime;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $updateTime;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
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
     * Method to set the value of field Createtime
     *
     * @param string $Createtime
     * @return $this
     */
    public function setCreatetime($Createtime)
    {
        $this->createTime = $Createtime;

        return $this;
    }

    /**
     * Method to set the value of field Updatetime
     *
     * @param string $Updatetime
     * @return $this
     */
    public function setUpdatetime($Updatetime)
    {
        $this->updateTime = $Updatetime;

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
     * Returns the value of field Createtime
     *
     * @return string
     */
    public function getCreatetime()
    {
        return $this->createTime;
    }

    /**
     * Returns the value of field Updatetime
     *
     * @return string
     */
    public function getUpdatetime()
    {
        return $this->updateTime;
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
        $this->setSource("tb_resource");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_resource';
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

    public function getInfo(){
        $resource='\Zejicrm\Modules\Frontend\Models\Resource';//需要全命名
        $sql="select * from {$resource}";
         $query=$this->di['modelsManager']->createQuery($sql);
        return $query->execute();
    }
}
