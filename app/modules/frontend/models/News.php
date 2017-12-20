<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/12/18
 * Time: 14:20
 */
namespace Zejicrm\Modules\Frontend\Models;

class News extends \Zejicrm\Models\Base
{
    protected $id;

    protected $title;

    protected $subTitle;

    protected $content;

    protected $createdTime;

    protected $updatedTime;

    protected $categaryId;

    protected $img;

    protected $vCnt;


    public function __set($name, $value)
    {
       $this->$name=$value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
      return  $this->id=$id;
    }


    public function initialize()
    {
        $this->setSchema("zeji_qa");
        $this->setSource("tb_news");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tb_news';
    }


}