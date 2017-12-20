<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\Modules\Frontend\Models\Userlog;
use Zejicrm\Mylog;

class UserlogController extends ControllerBase
{
    private $model=array(
        'id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),
        'user_id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>0,'edit'=>0,'search'=>0,'detail'=>1),
        'user_name'=>array('type'=>'text','lable'=>'用户名','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>1,'gassearch'=>1,'detail'=>1),
        'createTime'=>array('type'=>'time','lable'=>'时间','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1,"searchOptions"=>array(
            'qt'=>'>=',
            'type'=>"between",
        )),
        'action'=>array('type'=>'select','lable'=>'类型','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1,'options'=>array(
            '1'=>array('text'=>'登陆','selected'=>1),
            '2'=>array('text'=>'登出','selected'=>0),
        )),
        'remark'=>array('type'=>'textarea','lable'=>'备注','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1),
    );

    public function initialize()
    {
        $this->view->setVar('treeId',5);
        $this->view->nodeName='userlog';
        parent::initialize();
    }


    /**
     * Searches for userlog
     */
    public function indexAction()
    {
        $model=$this->defaultSettingModel($this->model);
        $this->_index($model,'Userlog','Zejicrm\Modules\Frontend\Models\Userlog');
    }


    /**
     * Edits a userlog
     *
     * @param string $id
     */
    public function detailAction($id)
    {
        if (!$this->request->isPost()) {

            $tb_user_log = Userlog::findFirstByid($id);
            if (!$tb_user_log) {
                $this->flash->error("userlog was not found");

                $this->dispatcher->forward([
                    'controller' => "userlog",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $tb_user_log->getId();

            $this->tag->setDefault("id", $tb_user_log->getId());
            $this->tag->setDefault("user_id", $tb_user_log->getUserId());
            $this->tag->setDefault("user_name", $tb_user_log->getUserName());
            $this->tag->setDefault("createTime", $tb_user_log->getCreatetime());
            $this->tag->setDefault("action", $tb_user_log->getAction());
            $this->tag->setDefault("remark", $tb_user_log->getRemark());


            $model=$this->defaultSettingModel($this->model);
            $this->view->models=$model;

            $this->settingLayer();
            
        }
    }

    /**
     * Creates a new userlog
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "userlog",
                'action' => 'index'
            ]);

            return;
        }

        $tb_user_log = new Userlog();
        $tb_user_log->setUserId($this->request->getPost("user_id"));
        $tb_user_log->setUserName($this->request->getPost("user_name"));
        $tb_user_log->setCreatetime($this->request->getPost("createTime"));
        $tb_user_log->setAction($this->request->getPost("action"));
        $tb_user_log->setRemark($this->request->getPost("remark"));
        

        if (!$tb_user_log->save()) {
            foreach ($tb_user_log->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "userlog",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("userlog was created successfully");

        $this->dispatcher->forward([
            'controller' => "userlog",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a userlog edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "userlog",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $tb_user_log = Userlog::findFirstByid($id);

        if (!$tb_user_log) {
            $this->flash->error("userlog does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "userlog",
                'action' => 'index'
            ]);

            return;
        }

        $tb_user_log->setUserId($this->request->getPost("user_id"));
        $tb_user_log->setUserName($this->request->getPost("user_name"));
        $tb_user_log->setCreatetime($this->request->getPost("createTime"));
        $tb_user_log->setAction($this->request->getPost("action"));
        $tb_user_log->setRemark($this->request->getPost("remark"));
        

        if (!$tb_user_log->save()) {

            foreach ($tb_user_log->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "userlog",
                'action' => 'edit',
                'params' => [$tb_user_log->getId()]
            ]);

            return;
        }

        $this->flash->success("userlog was updated successfully");

        $this->dispatcher->forward([
            'controller' => "userlog",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a userlog
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $tb_user_log = Userlog::findFirstByid($id);
        if (!$tb_user_log) {
            $this->flash->error("userlog was not found");

            $this->dispatcher->forward([
                'controller' => "userlog",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tb_user_log->delete()) {

            foreach ($tb_user_log->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "userlog",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("userlog was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "userlog",
            'action' => "index"
        ]);
    }

}
