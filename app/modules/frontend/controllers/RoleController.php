<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\Modules\Frontend\Models\Resource;
use Zejicrm\Modules\Frontend\Models\Role;
use Zejicrm\AclEx;
use Zejicrm\Modules\Frontend\Models\RoleScreen;
use Zejicrm\Modules\Frontend\Services\ColumnsIndexservice;
use Zejicrm\Modules\Frontend\Services\Userservice;
use Zejicrm\Mylog;

class RoleController extends ControllerBase
{
//    /**
//     * Index action
//     */
//    public function indexAction()
//    {
//        $this->persistent->parameters = null;
//    }

    public function initialize()
    {
        $this->view->setVar('treeId',4);
        $this->view->nodeName='role';
        parent::initialize();
    }


    public $model=array(
        'role_id'=>array('type'=>'text','lable'=>'ID','show'=>1,'ispk'=>1,'edit'=>0),
        'role_name'=>array('type'=>'text','lable'=>'角色名','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'required'=>1,'rangelength'=>"[3,20]"),
//        'role_acl'=>array('type'=>'text','lable'=>'权限','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1),
        'role'=>array('type'=>'text','lable'=>'角色标识(唯一)','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1,'required'=>1,'remote'=>"/role/checkRole"),
        'remark'=>array('type'=>'textarea','lable'=>'备注','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'rangelength'=>"[5,60]"),
        'create_date'=>array('type'=>'time','lable'=>'创建时间','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1),
        'update_date'=>array('type'=>'time','lable'=>'更新时间','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1,'search'=>1, "searchOptions"=>array(
                'qt'=>'>=',
                'type'=>"between",
            )
        ),
        'data_level'=>array('type'=>'select','lable'=>'数据等级','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>1,'search'=>1,'options'=>array(
            "1"=>array('text'=>'所有人','selected'=>0),
            "2"=>array('text'=>'本人及小组','selected'=>1),
        )),
//        's_data_group_id'=>array('type'=>'select','lable'=>'类型','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1),
    );


    public function checkRoleAction(){
        $role=$_GET['role'];
        $user_info=Role::findFirstByRole($role);
        if($user_info)
            echo json_encode(array("角色标识已存在"));
        else
            echo "true";
        exit();
    }


    public $screen_model=array(
        'id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),
        'key'=>array('type'=>'select','lable'=>'键名','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1),
        'show'=>array('type'=>'radio','lable'=>'是否显示','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'orderby'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )
        ),
        'create'=>array('type'=>'radio','lable'=>'是否创建','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'orderby'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )
        ),
        'edit'=>array('type'=>'radio','lable'=>'是否编辑','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'orderby'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )

        ),
        'detail'=>array('type'=>'radio','lable'=>'显示详细','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )
        ),
        'gas'=>array('type'=>'radio','lable'=>'过滤','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )
        ),

        'role_id'=>array('type'=>'hidden','lable'=>'角色','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>0),
        'controller'=>array('type'=>'hidden','lable'=>'角色','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>0),
    );
    /**
     * Searches for role
     */
    public function indexAction()
    {
        $this->model=$this->defaultSettingModel($this->model);
        $this->_index($this->model,'Role','Zejicrm\Modules\Frontend\Models\Role',array(),'create_date desc');
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
     * Edits a role
     *
     * @param string $role_id
     */
    public function editAction($role_id)
    {
        if (!$this->request->isPost()) {

            $tb_role = Role::findFirstByrole_id($role_id);
            if (!$tb_role) {
                $this->flash->error("role was not found");

                $this->dispatcher->forward([
                    'controller' => "role",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->role_id = $tb_role->getRoleId();

            $this->tag->setDefault("role_id", $tb_role->getRoleId());
            $this->tag->setDefault("role", $tb_role->getRole());
            $this->tag->setDefault("role_name", $tb_role->getRoleName());
            $this->tag->setDefault("remark", $tb_role->getRemark());
            $this->tag->setDefault("create_date", $tb_role->getCreateDate());
            $this->tag->setDefault("update_date", $tb_role->getUpdateDate());
//            $this->tag->setDefault("role_acl", $tb_role->getRoleAcl());
            $model=$this->defaultSettingModel($this->model);
            $this->view->models=$model;

            //设置门板打开方式
            $this->settingLayer();
        }
    }

    /**
     * Creates a new role
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'index'
            ]);

            return;
        }

        $tb_role = new Role();
        $tb_role->setRoleId($this->request->getPost("role_id"));
        $tb_role->setRole($this->request->getPost("role"));
        $tb_role->setRoleName($this->request->getPost("role_name"));
        $tb_role->setRemark($this->request->getPost("remark"));
        $tb_role->setCreateDate(time());
        $tb_role->setUpdateDate(time());
        $tb_role->setRoleAcl($this->request->getPost("role_acl"));


//        try{
//
//        }catch (\Exception $ex){
//
//        }

        if (!$tb_role->save()===false) {
            foreach ($tb_role->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'new'
            ]);

            return;
        }else{
            (new Mylog($this->di))->log($this->dispatcher->getActionName(),'添加保存',
                array(
                    'controll'=>$this->dispatcher->getControllerName(),
                    'userId'=>$this->user_id,
                    'username'=>$this->nickname,
                    "data"=>$_POST
                ));

            return $this->redictAndforword(1,'success','添加成功','/role/index');
        }



    }

    /**
     * Saves a role edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'index'
            ]);

            return;
        }

        $role_id = $this->request->getPost("role_id");
        $tb_role = Role::findFirstByrole_id($role_id);

        if (!$tb_role) {
            $this->flash->error("role does not exist " . $role_id);

            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'index'
            ]);

            return;
        }

//        $tb_role->setRoleId($this->request->getPost("role_id"));
        $tb_role->setRole($this->request->getPost("role"));
        $tb_role->setRoleName($this->request->getPost("role_name"));
        $tb_role->setRemark($this->request->getPost("remark"));
        $tb_role->setUpdateDate(time());


        if (!$tb_role->save()) {

            foreach ($tb_role->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'edit',
                'params' => [$tb_role->getRoleId()]
            ]);

            return;
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'修改保存',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));

        $this->flash->success("role was updated successfully");

        $this->dispatcher->forward([
            'controller' => "role",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a role
     *
     * @param string $role_id
     */
    public function deleteAction($role_id)
    {
        $tb_role = Role::findFirstByrole_id($role_id);
        if (!$tb_role) {
            $this->flash->error("role was not found");

            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'index'
            ]);

            return;
        }

        if (!$tb_role->delete()) {

            foreach ($tb_role->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'search'
            ]);

            return;
        }


        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'删除:'.$role_id,
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_GET
            ));

        $this->flash->success("role was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "role",
            'action' => "index"
        ]);
    }


    public function notvisitedAction(){
//        die("<div style='margin: 30px 45%;width: 100px;'>无权限访问 <a href=\"javascript:history.back();\">返回</a></div>");
    }



    public function accessAction($role_id){
        $params['type']=2;
        $resouce=Resource::findByType(2);
        $resource_list=$resouce->toArray();

        $key_list=array(
            'role'=>'角色管理',
            'index'=>'首页管理',
            'customer'=>'客户管理',
            'customerfollow'=>'客户跟进',
            'dept'=>'部门管理',
            'dict'=>'数据字典',
            'order'=>'订单管理',
            'resource'=>'资源管理',
            'user'=>'员工管理',
            'userlog'=>'用户日志',
            'syslog'=>'系统日志',
            'usersales'=>'目标管理',
            'columns'=>'字段管理',
            'tongji'=>'统计',
            'customerremark'=>'客户备注',
        );

        $nocheck_list=array(
            'role'=>0,
            'index'=>0,
            'customer'=>0,
            'customerfollow'=>0,
            'dept'=>0,
            'dict'=>0,
            'order'=>0,
            'resource'=>0,
            'user'=>0,
            'userlog'=>0,
            'syslog'=>0,
            'usersales'=>0,
            'columns'=>0,
            'tongji'=>0,
        );

        $role=Role::findFirstByRoleId($role_id);
        $role=$role->toArray();
        if(empty($role['role_acl'])){
            $role_acl=array();
        }else{
            $role_acl=explode(',',$role['role_acl']);
        }



        $_resouce_list=array();
        foreach ($resource_list as $v){
            if(in_array($v['id'],$role_acl)){
                $v['selected']=1;
            }else{
                $v['selected']=0;

                $nocheck_list[$v['controller']]=1;
            }

            $_resouce_list[$v['controller']][]=$v;
        }

        $this->view->nocheck_list=$nocheck_list;
        $this->view->key_list=$key_list;
        $this->view->resource_list = $_resouce_list;
        $this->view->role_id=$role_id;

    }

    public function accessSaveAction($role_id){

        if($this->request->isPost()){
            $aclcheck= $this->request->getPost('aclcheck');
            if(count($aclcheck)>0){
                $role=Role::findFirstByrole_id($role_id);
                $role->setUpdateDate(time());
                $role->setRoleAcl(join(',',$aclcheck));

                if (!$role->save()) {

                    foreach ($role->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return  $this->dispatcher->forward([
                        'controller' => "role",
                        'action' => 'index'
                    ]);
                }
//                $this->session->acl=null;

                // 生成权限管理文件
                $this->makeFile();
                $this->flash->success("权限修改成功");

                (new Mylog($this->di))->log($this->dispatcher->getActionName(),'修改权限',
                    array(
                        'controll'=>$this->dispatcher->getControllerName(),
                        'userId'=>$this->user_id,
                        'username'=>$this->nickname,
                        "data"=>$_POST
                    ));


               // return  $this->response->redirect('/role/index');
                return  $this->dispatcher->forward([
                    'controller' => "role",
                    'action' => "index"
                ]);
            }
        }

    }

    /*
     *屏蔽字
     */
    public function screenAction($_model,$role_id){
        $this->view->setLayout("common-iframe");
        $selfCondition['condition']=array( 'role_id'=>[],
            'controller'=>[]);
        $selfCondition['condition_list']=array('role_id'=>$role_id,
            'controller'=>$_model);
        $this->screen_model['key']['options']=$this->setSelectOptions($this->getColumnsByShow($_model));
        $model=$this->defaultSettingModel($this->screen_model);
        $this->_index($model,'RoleScreen','Zejicrm\Modules\Frontend\Models\RoleScreen',$selfCondition,'update_time desc');
        $this->view->_model=$_model;
        $this->view->role_id=$role_id;
    }


    private function getColumnsByShow($controller){
        $_list=array();
        $list= (new ColumnsIndexservice($this->di))->getShowColumnsByController($controller);

       if($list){
           $list=$list->toArray();
           foreach ($list as $v){
               $_list[$v['key']]=$v['lable'];
           }
       }
        return $_list;
    }

    public function screenNewAction($controller,$role_id){
        $this->screen_model['key']['options']=$this->setSelectOptions($this->getColumnsByShow($controller));
        $model=$this->defaultSettingModel($this->screen_model);
        $this->view->models=$model;
        //设置门板打开方式'controller/action-layer';
        $this->settingLayer();

        $this->tag->setDefault("role_id", $role_id);
        $this->tag->setDefault("controller", $controller);


    }


    public function screenCreateAction(){
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'screen'
            ]);

            return;
        }

        $roleScreen= new RoleScreen();
        $roleScreen->setController($this->request->getPost("controller"));
        $roleScreen->setShow($this->request->getPost("show"));
        $roleScreen->setCreate($this->request->getPost("create"));
        $roleScreen->setEdit($this->request->getPost("edit"));
        $roleScreen->setDetail($this->request->getPost("detail"));
        $roleScreen->setGas($this->request->getPost("gas"));
        $roleScreen->setKey($this->request->getPost("key"));
        $roleScreen->setRoleId($this->request->getPost("role_id"));

        if (!$roleScreen->save()) {
            foreach ($roleScreen->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "role",
                'action' => 'screen'
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
        return $this->redictAndforword(1,'success','创建成功','/role/screen',[
            'controller' => "role",
            'action' => 'screen'
        ]);

    }

    public function screenDeleteAction($id){
       $roleScreen= RoleScreen::findFirstById($id);
       if($roleScreen){
           if (!$roleScreen->delete()) {

               foreach ($roleScreen->getMessages() as $message) {
                   $this->flash->error($message);
               }

               $this->dispatcher->forward([
                   'controller' => "role",
                   'action' => 'screen'
               ]);

               return;
           }

           return $this->redictAndforword(1,'success','删除成功','/role/screen',[
               'controller' => "role",
               'action' => 'screen'
           ]);

       }

    }


    /*
     * 修改数据访问等级
     */

    public function modifyDataLevelAction($role_id){
        //设置门板打开方式
        $this->settingLayer();
        $mode=array(
            'role_id'=>array('type'=>'hidden','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>1),
            'data_level'=>array('type'=>'select','lable'=>'数据访问等级','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,'options'=>array(
                '1'=>array('text'=>"所有",'selected'=>0),
                '2'=>array('text'=>"本人及小组",'selected'=>1)
            )),
        );
        $model=$this->defaultSettingModel($mode);
         $role= Role::findFirstByRoleId($role_id);
         if(!$role){
             return $this->redictAndforword(2,'error','','/role/index',[
                 'controller' => "role",
                 'action' => 'index'
             ]);
         }
        $this->tag->setDefault("role_id", $role_id);
        $this->tag->setDefault("data_level", $role->getDataLevel());
        $this->view->models=$model;

    }


    public function saveDataLevelAction(){
        if ($this->request->isPost()) {
            $role_id = $this->request->getPost("role_id");
            $tb_role = Role::findFirstByRoleId($role_id);

            $tb_role->setDataLevel($this->request->getPost("data_level"));
            if(!$tb_role->save()){
                return $this->redictAndforword(2,'error','','/role/modifyDataLevel',[
                    'controller' => "role",
                    'action' => 'modifyDataLevel'
                ]);
            }else{


                (new Mylog($this->di))->log($this->dispatcher->getActionName(),'修改数据访问等级',
                    array(
                        'controll'=>$this->dispatcher->getControllerName(),
                        'userId'=>$this->user_id,
                        'username'=>$this->nickname,
                        "data"=>$_POST
                    ));

                return $this->redictAndforword(2,'success','','/role/modifyDataLevel',[
                    'controller' => "role",
                    'action' => 'modifyDataLevel'
                ]);
            }
        }
        return $this->redictAndforword(2,'error','invaild','/role/modifyDataLevel',[
            'controller' => "role",
            'action' => 'modifyDataLevel'
        ]);

    }


    /*
     *   授权访问其他小组数据权限
     */
    public function authDataGroupAction($role_id){

        $mode=array(
            'role_id'=>array('type'=>'hidden','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>1),
            's_data_group_id'=>array('type'=>'select','lable'=>'授权小组','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1),
        );
        $relation=array();
        $user_list=array();
        $select_list=array();

        $treelist=(new Userservice($this->di))->getOneGroupChild(0,2,array());

        //获取节点
        foreach ($treelist as $item) {
            $relation[$item['group_leader_id']][]=$item['user_id'];
            $user_list[$item['user_id']]=array(
                'name'=>$item['staff_name'],
                'level'=>intval($item['level']),
                'user_id'=>intval($item['user_id'])
                );
        }

        $jidian_list=array_keys($relation);

        foreach ($jidian_list as $k=>$key){
            if(isset($user_list[$key]))
             $select_list[$key]=$user_list[$key]['name'];
        }

        $mode['s_data_group_id']['options']=$this->setSelectOptions($select_list,array('0'=>'不授权'));
        $mode['s_data_group_id']['multiple']=1;
        $model=$this->defaultSettingModel($mode);

        $role= Role::findFirstByRoleId($role_id);
        if(!$role){
            return $this->redictAndforword(2,'error','','/role/index',[
                'controller' => "role",
                'action' => 'index'
            ]);
        }
        $role->getSDataGroupId();
        $this->tag->setDefault("role_id", $role_id);
        $s_data_group_id=$role->getSDataGroupId();
        if(isset($s_data_group_id)){
            $s_data_group_ids=json_decode($s_data_group_id,true);
        }
        $this->view->setVar('s_data_group_id',$s_data_group_ids);


        //设置门板打开方式
        $this->settingLayer();
        $this->view->models=$model;
    }

    public function saveAuthDataGroupAction(){
        if ($this->request->isPost()) {
            $role_id = $this->request->getPost("role_id");
            $tb_role = Role::findFirstByRoleId($role_id);
            $s_data_group_ids=$this->request->getPost("s_data_group_id");
            $_s_data_group_ids=[];
            if(!$s_data_group_ids){
                $_s_data_group_ids=[0];
            }else{
                foreach ($s_data_group_ids as $v){
                    $_s_data_group_ids[]=intval($v);
                }

                if(in_array(0,$_s_data_group_ids)){
                    $_s_data_group_ids=[0];
                }
            }
            $tb_role->setSDataGroupId(json_encode($_s_data_group_ids));
            if(!$tb_role->save()){
                return $this->redictAndforword(2,'error','','/role/authDataGroup',[
                    'controller' => "role",
                    'action' => 'authDataGroup'
                ]);
            }else{

                (new Mylog($this->di))->log($this->dispatcher->getActionName(),'授权不同组',
                    array(
                        'controll'=>$this->dispatcher->getControllerName(),
                        'userId'=>$this->user_id,
                        'username'=>$this->nickname,
                        "data"=>$_POST
                    ));

                return $this->redictAndforword(2,'success','','/role/authDataGroup',[
                    'controller' => "role",
                    'action' => 'authDataGroup'
                ]);
            }
        }
        return $this->redictAndforword(2,'error','invaild','/role/authDataGroup',[
            'controller' => "role",
            'action' => 'authDataGroup'
        ]);


    }



    private function makeFile(){
       $acl_make=new AclEx($this->di);
       $acl_make->makeFile();
//       $exist= $acl_make->FileExist();
//       if(!$exist){
//           $acl_make->makeFile();
//       }
    }

}
