<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\FileEx;
use Zejicrm\Modules\Frontend\Models\Dict;
use Zejicrm\Mylog;

class DictController extends ControllerBase
{


    private $model=array(
        'id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),
        'key'=>array('type'=>'text','lable'=>'键名','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'required'=>1,'rangelength'=>"[1,32]"),
        'value'=>array('type'=>'text','lable'=>'键值','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'required'=>1,'rangelength'=>"[1,32]"),
        'type'=>array('type'=>'select','lable'=>'类型','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1),
    );


    private function settingDictToModel(){
        $this->model['type']['options']=$this->setSelectOptions($this->getDictByStatic('dictType'));
    }

    public function initialize()
    {
        $this->settingDictToModel();
        $this->view->setVar('treeId',4);
        $this->view->nodeName='dict';
        parent::initialize();
    }


    /**
     * index for dict
     */
    public function indexAction()
    {
        $model=$this->defaultSettingModel($this->model);
        $this->_index($model,'Syslog','Zejicrm\Modules\Frontend\Models\Dict');
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $model=$this->defaultSettingModel($this->model);
        $this->view->models=$model;
        //设置门板打开方式'controller/action-layer';
        $this->settingLayer();
    }

    /**
     * Edits a dict
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $dict = Dict::findFirstByid($id);
            if (!$dict) {
                $this->flash->error("dict was not found");

                $this->dispatcher->forward([
                    'controller' => "dict",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $dict->getId();

            $this->tag->setDefault("id", $dict->getId());
            $this->tag->setDefault("key", $dict->getKey());
            $this->tag->setDefault("value", $dict->getValue());
            $this->tag->setDefault("type", $dict->getType());

            $model=$this->defaultSettingModel($this->model);
            $this->view->models=$model;

            //设置门板打开方式
            $this->settingLayer();
            
        }
    }

    /**
     * Creates a new dict
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->redictAndforword(2,'error','失败','/dict/index',[
                'controller' => "dict",
                'action' => 'index'
            ]);

            return;
        }

        $dict = new Dict();
        $dict->setKey($this->request->getPost("key"));
        $dict->setValue($this->request->getPost("value"));
        $dict->setType($this->request->getPost("type"));
        

        if (!$dict->save()) {
            foreach ($dict->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->redictAndforword(2,'error','成功','/dict/index',[
                'controller' => "dict",
                'action' => 'index'
            ]);

            return;
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'create',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));


        return $this->redictAndforword(2,'success','成功','/dict/index',[
            'controller' => "dict",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a dict edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redictAndforword(2,'error','成功','/dict/index',[
                'controller' => "dict",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $dict = Dict::findFirstByid($id);

        if (!$dict) {


            return;
        }

        $dict->setKey($this->request->getPost("key"));
        $dict->setValue($this->request->getPost("value"));
        $dict->setType($this->request->getPost("type"));
        

        if (!$dict->save()) {

            foreach ($dict->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "dict",
                'action' => 'edit',
                'params' => [$dict->getId()]
            ]);

            return;
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'create',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));

        return $this->redictAndforword(2,'success','成功','/dict/index',[
            'controller' => "dict",
            'action' => 'index'
        ]);

    }

    /**
     * Deletes a dict
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $dict = Dict::findFirstByid($id);
        if (!$dict) {
            $this->flash->error("dict was not found");

            return $this->redictAndforword(2,'error','成功','/dict/index',[
                'controller' => "dict",
                'action' => 'index'
            ]);

        }

        if (!$dict->delete()) {

            foreach ($dict->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->redictAndforword(2,'error','成功','/dict/index',[
                'controller' => "dict",
                'action' => 'index'
            ]);


            return;
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'delete:'.$id,
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_GET
            ));

        return $this->redictAndforword(2,'success','成功','/dict/index',[
            'controller' => "dict",
            'action' => 'index'
        ]);

    }

    public function makeDictAction(){
            $fileEx=new FileEx($this->di,'dict.json');
            $list=array();

            $dictType= $this->getDictByStatic('dictType');

            $dictAll=Dict::find();
             $dictAll=$dictAll->toArray();
             foreach ($dictAll as $dict){
                 $list[$dict['type']][$dict['key']]=$dict['value'];
             }
            $fileEx->makeFile($list);
            return  $this->response->redirect('/dict/index');
    }

}
