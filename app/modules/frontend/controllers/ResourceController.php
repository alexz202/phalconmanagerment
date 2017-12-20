<?php

namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\Modules\Frontend\Models\Resource;
use Zejicrm\Mylog;


class ResourceController extends ControllerBase
{
//    /**
//     * Index action
//     */
//    public function searchAction()
//    {
//
//        $this->persistent->parameters = null;
//    }

    public function initialize()
    {
        $this->view->setVar('treeId',4);
        $this->view->nodeName='resource';
        $this->view->setVar('typelist',array('1'=>'共有','2'=>'私有'));
        parent::initialize();
    }


    /**
     * Index for resource
     */
    public function indexAction()
    {
        $numberPage = 1;
        if ($this->request->isGet()) {
            $query = Criteria::fromInput($this->di, 'Zejicrm\Modules\Frontend\Models\Resource', $_GET);
            $this->persistent->parameters = $query->getParams();
        } else {

        }
        $numberPage = $this->request->getQuery("page", "int");

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $tb_resource = Resource::find($parameters);
        if (count($tb_resource) == 0) {
            $this->flash->notice("The search did not find any resource");

            $this->dispatcher->forward([
                "controller" => "resource",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $tb_resource,
            'limit'=> 20,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'访问：',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_GET
            ));
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {


    }

    /**
     * Edits a resource
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $tb_resource = Resource::findFirstByid($id);
            if (!$tb_resource) {
                $this->flash->error("resource was not found");

                $this->dispatcher->forward([
                    'controller' => "resource",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $tb_resource->getId();

            $this->tag->setDefault("id", $tb_resource->getId());
            $this->tag->setDefault("controller", $tb_resource->getController());
            $this->tag->setDefault("action", $tb_resource->getAction());
            $this->tag->setDefault("remark", $tb_resource->getRemark());
//            $this->tag->setDefault("createTime", $tb_resource->getCreatetime());
//            $this->tag->setDefault("updateTime", $tb_resource->getUpdatetime());
            $this->tag->setDefault("type", $tb_resource->getType());
            
        }
    }

    /**
     * Creates a new resource
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "resource",
                'action' => 'index'
            ]);

            return;
        }
        $nowtime=time();

        $tb_resource = new Resource();
        $tb_resource->setController($this->request->getPost("controller"));
        $tb_resource->setAction($this->request->getPost("action"));
        $tb_resource->setRemark($this->request->getPost("remark"));
        $tb_resource->setCreatetime($nowtime);
        $tb_resource->setUpdatetime($nowtime);
        $tb_resource->setType($this->request->getPost("type"));

        

        if (!$tb_resource->save()) {
            foreach ($tb_resource->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "resource",
                'action' => 'new'
            ]);

            return;
        }

        //$this->flash->success("resource was created successfully");

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'添加',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));

         return $this->redictAndforword(1,'success','添加成功','/resource/index');

//        $this->dispatcher->forward([
//            'controller' => "resource",
//            'action' => 'index'
//        ]);
    }

    /**
     * Saves a resource edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "resource",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $tb_resource = Resource::findFirstByid($id);

        if (!$tb_resource) {
            $this->flash->error("resource does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "resource",
                'action' => 'index'
            ]);

            return;
        }

        $tb_resource->setController($this->request->getPost("controller"));
        $tb_resource->setAction($this->request->getPost("action"));
        $tb_resource->setRemark($this->request->getPost("remark"));
//        $tb_resource->setCreatetime($this->request->getPost("createTime"));
        $tb_resource->setUpdatetime(time());
        $tb_resource->setType($this->request->getPost("type"));
        

        if (!$tb_resource->save()) {

            foreach ($tb_resource->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "resource",
                'action' => 'edit',
                'params' => [$tb_resource->getId()]
            ]);

            return;
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'修改',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));

        $this->flash->success("resource was updated successfully");

        $this->dispatcher->forward([
            'controller' => "resource",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a resource
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $tb_resource = Resource::findFirstByid($id);
        if (!$tb_resource) {
            $this->flash->error("resource was not found");

            $this->dispatcher->forward([
                'controller' => "resource",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tb_resource->delete()) {

            foreach ($tb_resource->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "resource",
                'action' => 'search'
            ]);

            return;
        }


        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'删除:'.$id,
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_GET
            ));

        $this->flash->success("resource was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "resource",
            'action' => "index"
        ]);
    }

}
