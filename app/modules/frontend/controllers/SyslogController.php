<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\Modules\Frontend\Models\Syslog;
use Zejicrm\Mylog;

class SyslogController extends ControllerBase
{
    private $model=array(
        'id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),
        'user_id'=>array('type'=>'text','lable'=>'用户ID','show'=>1,'ispk'=>0,'edit'=>0,'search'=>0,'detail'=>1,'width'=>'10%'),
        'user_name'=>array('type'=>'text','lable'=>'用户名','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>1,'gassearch'=>1,'detail'=>1,'width'=>'10%'),
        'controller'=>array('type'=>'text','lable'=>'控制器','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1,'width'=>'10%'),
        'action'=>array('type'=>'text','lable'=>'行为','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1,'width'=>'10%'),
        'remark'=>array('type'=>'text','lable'=>'备注','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1,'width'=>'10%'),
        'updateTime'=>array('type'=>'time','lable'=>'记录时间','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1,'width'=>'10%',"searchOptions"=>array(
            'qt'=>'>=',
            'type'=>"between",
        ),'search'=>1),
        'data'=>array('type'=>'text','lable'=>'参数','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1,'width'=>'15%'),
    );

    public function initialize()
    {
        $this->view->setVar('treeId',5);
        $this->view->nodeName='syslog';
        parent::initialize();
    }

    /**
     * Searches for syslog
     */
    public function indexAction()
    {
        $model=$this->defaultSettingModel($this->model);
        $this->_index($model,'Syslog','Zejicrm\Modules\Frontend\Models\Syslog');
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a syslog
     *
     * @param string $id
     */
    public function detailAction($id)
    {
        if (!$this->request->isPost()) {

            $tb_sys_log = Syslog::findFirstByid($id);
            if (!$tb_sys_log) {
                $this->flash->error("syslog was not found");

                $this->dispatcher->forward([
                    'controller' => "syslog",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $tb_sys_log->getId();

            $this->tag->setDefault("id", $tb_sys_log->getId());
            $this->tag->setDefault("user_id", $tb_sys_log->getUserId());
            $this->tag->setDefault("user_name", $tb_sys_log->getUserName());
            $this->tag->setDefault("controller", $tb_sys_log->getController());
            $this->tag->setDefault("action", $tb_sys_log->getAction());
            $this->tag->setDefault("remark", $tb_sys_log->getRemark());
            $this->tag->setDefault("updateTime", $tb_sys_log->getUpdatetime());
            $this->tag->setDefault("data", $tb_sys_log->getData());

            $model=$this->defaultSettingModel($this->model);
            $this->view->models=$model;

            $this->settingLayer();

        }
    }

    /**
     * Creates a new syslog
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "syslog",
                'action' => 'index'
            ]);

            return;
        }

        $tb_sys_log = new Syslog();
        $tb_sys_log->setUserId($this->request->getPost("user_id"));
        $tb_sys_log->setUserName($this->request->getPost("user_name"));
        $tb_sys_log->setController($this->request->getPost("controller"));
        $tb_sys_log->setAction($this->request->getPost("action"));
        $tb_sys_log->setRemark($this->request->getPost("remark"));
        $tb_sys_log->setUpdatetime($this->request->getPost("updateTime"));
        $tb_sys_log->setData($this->request->getPost("data"));
        

        if (!$tb_sys_log->save()) {
            foreach ($tb_sys_log->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "syslog",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("syslog was created successfully");

        $this->dispatcher->forward([
            'controller' => "syslog",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a syslog edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "syslog",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $tb_sys_log = Syslog::findFirstByid($id);

        if (!$tb_sys_log) {
            $this->flash->error("syslog does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "syslog",
                'action' => 'index'
            ]);

            return;
        }

        $tb_sys_log->setUserId($this->request->getPost("user_id"));
        $tb_sys_log->setUserName($this->request->getPost("user_name"));
        $tb_sys_log->setController($this->request->getPost("controller"));
        $tb_sys_log->setAction($this->request->getPost("action"));
        $tb_sys_log->setRemark($this->request->getPost("remark"));
        $tb_sys_log->setUpdatetime($this->request->getPost("updateTime"));
        $tb_sys_log->setData($this->request->getPost("data"));
        

        if (!$tb_sys_log->save()) {

            foreach ($tb_sys_log->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "syslog",
                'action' => 'edit',
                'params' => [$tb_sys_log->getId()]
            ]);

            return;
        }

        $this->flash->success("syslog was updated successfully");

        $this->dispatcher->forward([
            'controller' => "syslog",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a syslog
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $tb_sys_log = Syslog::findFirstByid($id);
        if (!$tb_sys_log) {
            $this->flash->error("syslog was not found");

            $this->dispatcher->forward([
                'controller' => "syslog",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tb_sys_log->delete()) {

            foreach ($tb_sys_log->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "syslog",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("syslog was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "syslog",
            'action' => "index"
        ]);
    }

}
