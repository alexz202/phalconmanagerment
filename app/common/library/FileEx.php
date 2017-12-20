<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/5
 * Time: 14:58
 */
namespace Zejicrm;

class FileEx {

    protected $_dependencyInjector;

    protected $file=null;

    public function __construct($dependencyInjector,$filename)
    {
        $this->_dependencyInjector = $dependencyInjector;
        $this->file=$filename;
    }

    public function makeFile($list){
       return $this->_dependencyInjector['fileCache']->save($this->file,json_encode($list),-1);
    }

    public function FileExist(){
        return  $this->_dependencyInjector['fileCache']->get($this->file);
    }







}
