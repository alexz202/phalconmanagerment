<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\FileEx;
use Zejicrm\Modules\Frontend\Models\Dict;
use Zejicrm\Modules\Frontend\Models\News;
use Zejicrm\Mylog;

class NewsController extends ControllerBase
{

    private $model=array(
        'id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),
        'title'=>array('type'=>'text','lable'=>'标题','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'required'=>1,'rangelength'=>"[1,32]"),
        'subTitle'=>array('type'=>'text','lable'=>'副标题','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'required'=>1,'rangelength'=>"[1,32]"),
        'content'=>array('type'=>'editor','lable'=>'内容','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1),
        'img'=>array('type'=>'image','lable'=>'缩略图','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1,'makeThumb'=>0),
        'vCnt'=>array('type'=>'number','lable'=>'点击次数','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1),
       // 'categaryId'=>array('type'=>'select','lable'=>'分类','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1),
        'createdTime'=>array('type'=>'time','lable'=>'创建时间','show'=>1,'edit'=>0,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1),
        'updatedTime'=>array('type'=>'time','lable'=>'更新时间','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1,'search'=>1),
    );


    private function settingDictToModel(){
//        $this->model['type']['options']=$this->setSelectOptions($this->getDictByStatic('dictType'));
        $this->model['img']['foloder']='images';
        $verifyToken = md5('upupload123!@#' . $this->model['img']['foloder']);
        $this->model['img']['token']=$verifyToken;
    }

    public function initialize()
    {
        $this->settingDictToModel();
        $this->view->setVar('treeId',1);
        $this->view->nodeName='news';
        parent::initialize();
    }


    /**
     * index for dict
     */
    public function indexAction()
    {
        $model=$this->defaultSettingModel($this->model);
        $this->_index($model,'Syslog','Zejicrm\Modules\Frontend\Models\News');
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

            $news = News::findFirstByid($id);
            if (!$news) {
                $this->flash->error("news was not found");

                $this->dispatcher->forward([
                    'controller' => "news",
                    'action' => 'index'
                ]);
                return;
            }
            $this->view->id = $news->getId();
            $this->tag->setDefault("id", $news->id);
            $this->tag->setDefault("title", $news->title);
            $this->tag->setDefault("subTitle", $news->subTitle);
            $this->tag->setDefault("content", $news->content);
            $this->tag->setDefault("img", $news->img);
            $this->tag->setDefault("vCnt", $news->vCnt);
            $this->tag->setDefault("updateTime",$news->updateTime);

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
            return $this->redictAndforword(2,'error','失败','/news/index',[
                'controller' => "news",
                'action' => 'index'
            ]);

            return;
        }

        $news = new News();
        $news->title=$this->request->getPost("title");
        $news->subTitle=$this->request->getPost("subTitle");
        $news->content=$this->request->getPost("content");
        $news->img=$this->request->getPost("img");
        $news->vCnt=0;
        $news->createdTime=time();
        $news->updateTime=time();


        if (!$news->save()) {
            foreach ($news->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->redictAndforword(2,'error','成功','/news/index',[
                'controller' => "news",
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


        return $this->redictAndforword(2,'success','成功','/news/index',[
            'controller' => "news",
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
                'controller' => "news",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $news = News::findFirstByid($id);

        if (!$news) {

            return;
        }

        $news->title=$this->request->getPost("title");
        $news->subTitle=$this->request->getPost("subTitle");
        $news->content=$this->request->getPost("content");
        $news->img=$this->request->getPost("img");

        if (!$news->save()) {

            foreach ($news->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "news",
                'action' => 'edit',
                'params' => [$news->getId()]
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

        return $this->redictAndforword(2,'success','成功','/news/index',[
            'controller' => "news",
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
        $dict = News::findFirstByid($id);
        if (!$dict) {
            $this->flash->error("news was not found");

            return $this->redictAndforword(2,'error','成功','/news/index',[
                'controller' => "dict",
                'action' => 'index'
            ]);

        }

        if (!$dict->delete()) {

            foreach ($dict->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->redictAndforword(2,'error','成功','/news/index',[
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

        return $this->redictAndforword(2,'success','成功','/news/index',[
            'controller' => "news",
            'action' => 'index'
        ]);

    }


}
