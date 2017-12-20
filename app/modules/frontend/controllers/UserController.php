<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;

use Phalcon\Paginator\Adapter\Model as Paginator;

use Zejicrm\Modules\Frontend\Models\Dept;
use Zejicrm\Modules\Frontend\Models\Role;
use Zejicrm\Modules\Frontend\Models\User;
use Zejicrm\Modules\Frontend\Services\Deptservice;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Zejicrm\Modules\Frontend\Services\Usergsservice;
use Zejicrm\Modules\Frontend\Services\Usersalesservice;
use Zejicrm\Modules\Frontend\Services\Userservice;
use Zejicrm\Mylog;

class UserController extends ControllerBase
{

    private $model=array(
        'user_id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),

        'sub_account_id'=>array('type'=>'text','lable'=>'职员ID(唯一)','show'=>1,'edit'=>0,'ispk'=>0,'create'=>1,'search'=>1,'gassearch'=>0,'detail'=>1,'required'=>1,'remote'=>"/user/checkSubAccountId"),

        'staff_name'=>array('type'=>'text','lable'=>'姓名','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>1,'gassearch'=>0,'detail'=>1,
        "searchOptions"=>array(
                'qt'=>'like',
                'type'=>"and",
            )),

        'staff_alias'=>array('type'=>'text','lable'=>'别名','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1),


      //  'dept'=>array('type'=>'select','lable'=>'部门','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>1,'gassearch'=>0,'detail'=>1),//??

     //   'position'=>array('type'=>'text','lable'=>'职位','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1),

        'mobile_phone'=>array('type'=>'text','lable'=>'移动电话','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1),

        'user_role'=>array('type'=>'select','lable'=>'角色授权','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1,'search'=>1,'orderby'=>1),//

        'state'=>array('type'=>'select','lable'=>'状态','show'=>0,'edit'=>0,'ispk'=>0,'create'=>0,'detail'=>0,'search'=>0,'options'=>array(
            "1"=>array("text"=>"禁用","selected"=>0),
            "2"=>array("text"=>"启用","selected"=>1),
//            "3"=>array("text"=>"用户检查","selected"=>0),
        ),'select'=>1,'orderby'=>1),


        'remark'=>array('type'=>'textarea','lable'=>'备注','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1),

        'is_login_allow'=>array('type'=>'radio','lable'=>'是否允许登陆系统','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>0,'options'=>array(
            '1'=>array('text'=>'允许','selected'=>1),
            '0'=>array('text'=>'不允许','selected'=>0),
        )),

        'create_date'=>array('type'=>'time','lable'=>'创建日期','show'=>1,'ispk'=>0,'edit'=>0,'create'=>0,'detail'=>1),
        'update_date'=>array('type'=>'time','lable'=>'更新时间','show'=>1,'ispk'=>0,'edit'=>0,'create'=>0,'detail'=>1),

//        'zipcode'=>array('type'=>'text','lable'=>'邮编','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'detail'=>1),


    );

    public function checkSubAccountIdAction(){
        $sub_account_id=$_GET['sub_account_id'];
        $user_info=User::findFirstBySubAccountId($sub_account_id);
        if($user_info)
            echo json_encode(array("用户账号已存在"));
        else
           echo "true";
        exit();
    }

    /*
     * 更新
     */

    public function updateGsAction(){
        if($this->request->isAjax()){
            $gsid= $this->request->getPost('gsid');
            $value=$this->request->getPost('value');
            $res= (new Usergsservice($this->di))->updateGs($gsid,$value);
            if($res){
                $this->createJsonReturn(1,'success');
            }else{
                $this->createJsonReturn(0,'fail',array());
            }
        }
    }


    //新增
    public function setGsKeyAction(){
        if($this->request->isAjax()) {
            $pix = $this->request->getPost('pix');
            $value = $this->request->getPost('value');
            $key = $this->request->getPost('key');
            $type = $this->user_id . "_" . $pix;

            $res = (new Usergsservice($this->di))->setKeyValue($type, $key, $value);
            if ($res) {
                $this->createJsonReturn(1, 'success',array('id'=>$res));
            } else {
                $this->createJsonReturn(0, 'fail', array('type' => $type, 'value' => $value));
            }
        }

    }

    /*
    * 删除
    */

    public function delGsAction(){
        if($this->request->isAjax()){
            $gsid= $this->request->getPost('gsid');
            $res= (new Usergsservice($this->di))->delGs($gsid);
            if($res){
                $this->createJsonReturn(1,'success');
            }else{
                $this->createJsonReturn(0,'fail',array());
            }
        }
    }

    public function initialize()
    {
        $this->settingDictToModel();
        $this->view->setVar('treeId',4);
        parent::initialize();
    }



    private function settingDictToModel(){
        $default_params['0']='最高';
//        $this->model['parent_staff_seed']['options']=$this->setSelectOptions($this->getAccountIdList(2));
//        $this->model['group_leader_id']['options']=$this->setSelectOptions($this->getAccountIdList(2),$default_params);
        $this->model['user_role']['options']=$this->setSelectOptions($this->getRole());
       // $this->model['dept']['options']=$this->getDeptOptions();
//        $this->model['sales_level']['options']=$this->setSelectOptions($this->getDict('12'));
        $this->view->setVar('sub_account_idJson',json_encode($this->setSuggestOptions($this->getAccountIdList(2),$default_params)));
        $this->view->setVar('selectSubAccountIdOptionsJson',json_encode($this->setSuggestOptions($this->getAccountIdList(2),$default_params)));
    }


    private function getRole(){
        $role=Role::find();
        $list=array();
        foreach ($role as $item){
            $list[$item->getRoleId()]=$item->getRoleName();
        }
        return $list;
    }



    /**
     * Searches for user
     */
    public function indexAction()
    {
        $this->model=$this->defaultSettingModel($this->model);
        $this->model['is_login_allow']['tag']=1;
        $condition['is_delete']=[];
        $condition_list['is_delete']=0;
        $selfCondition=array('condition'=>$condition,
                        'condition_list'=>$condition_list
        );
        $this->_index($this->model,'User','Zejicrm\Modules\Frontend\Models\User',$selfCondition,'user_id desc');
        $this->view->nodeName='user';
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

        $this->model['dept']['options']=$this->getDeptOptions();

        $model=$this->defaultSettingModel($this->model);
        $this->view->models=$model;
        //设置门板打开方式'controller/action-layer';
        $this->settingLayer();
        $this->view->setVar('sales_level_list', $this->getDict('12'));

    }

    /**
     * Edits a user
     *
     * @param string $userId
     */
    public function editAction($userId)
    {
        if (!$this->request->isPost()) {

            $tb_user = User::findFirstByuserId($userId);
            if (!$tb_user) {
                $this->flash->error("user was not found");

                $this->dispatcher->forward([
                    'controller' => "user",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->userId = $tb_user->getUserid();

            $this->tag->setDefault("user_id", $tb_user->getUserid());
            $this->tag->setDefault("address", $tb_user->getAddress());
            $this->tag->setDefault("comm_email", $tb_user->getCommEmail());
            $this->tag->setDefault("comm_fax", $tb_user->getCommFax());
            $this->tag->setDefault("comm_phone", $tb_user->getCommPhone());
            $this->tag->setDefault("dead_line", $tb_user->getDeadLine());
            $this->tag->setDefault("dept", $tb_user->getDept());
//            $this->tag->setDefault("password", $tb_user->getPassword());
            $this->tag->setDefault("is_duty_sales", $tb_user->getIsDutySales());
            $this->tag->setDefault("is_duty_service_staff", $tb_user->getIsDutyServiceStaff());
            $this->tag->setDefault("is_login_allow", $tb_user->getIsLoginAllow());
            $this->tag->setDefault("mobile_phone", $tb_user->getMobilePhone());
            $this->tag->setDefault("parent_staff_seed", $tb_user->getParentStaffSeed());
            $this->tag->setDefault("position", $tb_user->getPosition());
            $this->tag->setDefault("remark", $tb_user->getRemark());
            $this->tag->setDefault("seat_phone", $tb_user->getSeatPhone());
            $this->tag->setDefault("staff_alias", $tb_user->getStaffAlias());
            $this->tag->setDefault("staff_name", $tb_user->getStaffName());
            $this->tag->setDefault("state", $tb_user->getState());
            $this->tag->setDefault("sub_account_id", $tb_user->getSubAccountId());

            $this->tag->setDefault("user_role", $tb_user->getUserRole());
            $this->tag->setDefault("zipcode", $tb_user->getZipcode());
            $this->tag->setDefault("group_leader_id", $tb_user->getGroupLeaderId());
            $this->tag->setDefault("is_leader", $tb_user->getIsLeader());
            $this->tag->setDefault("sales_level", $tb_user->getSalesLevel());

            $model=$this->defaultSettingModel($this->model);
            $this->view->models=$model;

            $this->view->setVar('sales_level_list', $this->getDict('12'));
            //设置门板打开方式
            $this->settingLayer();

        }
    }


    public function detailAction($userId){
        $this->editAction($userId);
    }


    /*
     * type 1:create 2:update
     */
    private  function filterLevel($user_id,$orign_group_id,$aim_group_id,$orign_level,$type=1,&$error=''){
        if($type==1){

            if($aim_group_id==0){
                $level=0;
            }else{
                $user=User::findFirstByUserId($aim_group_id);
                $level=intval($user->getLevel());
            }
            return $level+1;
        }else{

            if($user_id==$aim_group_id){
                $error="不能属于自己";
                return false;
            }

            //判断能不能移动
            //origin_tree 是不是包含 group_id 父不能和子集交换。
            $userService=new Userservice($this->di);
            $children=array();
            $child_ids=array();
            $child_list=array();


            $children=$userService->getOneGroupChild($user_id,2);
            $has_child=0;

            if(count($children)>0){
                $has_child=1;
                foreach ($children as $child) {
                    $child_list[$child['user_id']]=$child['level'];
                    $child_ids[]=$child['user_id'];
                }

            }

            if(count($child_ids)>0&&in_array($aim_group_id,$child_ids)){
                $error="父不能移动到点下面";
                return false;
            }
            $aim_group=User::findFirstByUserId($aim_group_id);
            $aim_level=intval($aim_group->getLevel())+1;
            //更新Level;

            if($has_child==1){
                $userService->updateGroupLeader($child_list,$aim_level);
            }
            return $aim_level;
        }
    }

    /**
     * Creates a new user
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {

            return $this->redictAndforword(2,'error','','/user/index',[
                'controller' => "user",
                'action' => 'index'
            ]);
        }

        $exist=User::findFirstBySubAccountId($this->request->getPost("sub_account_id"));

        if($exist){
            return $this->redictAndforword(2,'error','账号名已存在','/user/index',[
                'controller' => "user",
                'action' => 'index'
            ]);
        }

        $tb_user = new User();
        $tb_user->setAddress($this->request->getPost("address"));
        $tb_user->setCommEmail($this->request->getPost("comm_email"));
        $tb_user->setCommFax($this->request->getPost("comm_fax"));
        $tb_user->setCommPhone($this->request->getPost("comm_phone"));
        $tb_user->setCreateDate(time());
        $tb_user->setCreateMan($this->sub_account_id);
        $tb_user->setDeadLine($this->request->getPost("dead_line"));
        $tb_user->setDept($this->request->getPost("dept"));
        $tb_user->setPassword(md5(123456));
        $tb_user->setIsDutySales($this->request->getPost("is_duty_sales"));
        $tb_user->setIsDutyServiceStaff($this->request->getPost("is_duty_service_staff"));
        $tb_user->setIsLoginAllow($this->request->getPost("is_login_allow"));


        $tb_user->setMobilePhone($this->request->getPost("mobile_phone"));
        $tb_user->setParentStaffSeed($this->request->getPost("parent_staff_seed"));
        $tb_user->setPosition($this->request->getPost("position"));
        $tb_user->setRemark($this->request->getPost("remark"));
        $tb_user->setSeatPhone($this->request->getPost("seat_phone"));
        $tb_user->setStaffAlias($this->request->getPost("staff_alias"));
        $tb_user->setStaffName($this->request->getPost("staff_name"));
     //   $tb_user->setState(2);
        $tb_user->setSubAccountId($this->request->getPost("sub_account_id"));

        $tb_user->setUpdateDate(time());
       $tb_user->setUpdateMan($this->sub_account_id);
        $tb_user->setUserRole($this->request->getPost("user_role"));
        $tb_user->setZipcode($this->request->getPost("zipcode"));
        $tb_user->setIsLeader($this->request->getPost("is_leader"));
        if(intval($this->request->getPost("is_duty_sales"))==1)
            $tb_user->setSalesLevel($this->request->getPost("sales_level"));

        $tb_user->setGroupLeaderId($this->request->getPost("group_leader_id"));

        $level=$this->filterLevel('',0,$this->request->getPost("group_leader_id"),0,1);
        $tb_user->setLevel($level);


        if (!$tb_user->save()) {
            $error="";
            foreach ($tb_user->getMessages() as $message) {
                $error.=$message.";";
            }

            return $this->redictAndforword(2,'error',$error,'/user/new',[
                'controller' => "user",
                'action' => 'new'
            ]);
        }else{
             $user_id= $tb_user->getUserid();
                $initUsersales= (new Usersalesservice($this->di))->initOneUserSale($user_id);

                (new Mylog($this->di))->log($this->dispatcher->getActionName(),'添加:'.$user_id,
                    array(
                        'controll'=>$this->dispatcher->getControllerName(),
                        'userId'=>$this->user_id,
                        'username'=>$this->nickname,
                        "data"=>$_POST

                    ));

            //清除用户列表缓存
            (new Userservice($this->di))->clearCacheByRedis();

            //$this->flash->success("user was created successfully");
            return $this->redictAndforword(1,'success','添加成功','/user/index',[
                'controller' => "user",
                'action' => 'index'
            ]);

        }


    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->redictAndforword(2,'error','','/user/index',[
                'controller' => "user",
                'action' => 'index'
            ]);
        }

        $userId = $this->request->getPost("user_id");

        $tb_user = User::findFirstByuserId($userId);

        if (!$tb_user) {

            return $this->redictAndforword(2,'error',"user does not exist " . $userId,'/user/index',[
                'controller' => "user",
                'action' => 'index'
            ]);
        }


        $tb_user->setAddress($this->request->getPost("address"));
        $tb_user->setCommEmail($this->request->getPost("comm_email"));
        $tb_user->setCommFax($this->request->getPost("comm_fax"));
        $tb_user->setCommPhone($this->request->getPost("comm_phone"));
        $tb_user->setDeadLine($this->request->getPost("dead_line"));
        $tb_user->setDept($this->request->getPost("dept"));
        $tb_user->setIsDutySales($this->request->getPost("is_duty_sales"));
        //$tb_user->setIsDutyServiceStaff($this->request->getPost("is_duty_service_staff"));

        $is_login_allow=$this->request->getPost("is_login_allow");
        if(isset($is_login_allow))
            $tb_user->setIsLoginAllow($is_login_allow);

//        $tb_user->setLastLogTime($this->request->getPost("last_log_time"));
      //  $tb_user->setLogTimes($this->request->getPost("log_times"));
        $tb_user->setMobilePhone($this->request->getPost("mobile_phone"));
        $tb_user->setParentStaffSeed($this->request->getPost("parent_staff_seed"));
        $tb_user->setPosition($this->request->getPost("position"));
        $tb_user->setRemark($this->request->getPost("remark"));
        $tb_user->setSeatPhone($this->request->getPost("seat_phone"));
        $tb_user->setStaffAlias($this->request->getPost("staff_alias"));
        $tb_user->setStaffName($this->request->getPost("staff_name"));
       // $tb_user->setState($this->request->getPost("state"));


//        $tb_user->setSubAccountId($this->request->getPost("sub_account_id"));
        $tb_user->setUpdateDate(time());
        $tb_user->setUpdateMan($this->sub_account_id);
        if(intval($this->request->getPost("is_duty_sales"))==1)
            $tb_user->setSalesLevel($this->request->getPost("sales_level"));

        $user_role=$this->request->getPost("user_role");
        if(isset($user_role))
            $tb_user->setUserRole($user_role);
        $tb_user->setZipcode($this->request->getPost("zipcode"));

        // 处理组长及LEVEL 更新
        if(intval($tb_user->getGroupLeaderId())!=intval($this->request->getPost("group_leader_id"))){
            $level=$this->filterLevel($userId,intval($tb_user->getGroupLeaderId()),intval($this->request->getPost("group_leader_id")),intval($tb_user->getLevel()),2,$message);
            if($level===false){
                return $this->redictAndforword(2,'error',$message,'/user/index',[
                    'controller' => "user",
                    'action' => 'index'
                ]);
            }

            $tb_user->setLevel($level);
            $tb_user->setGroupLeaderId(intval($this->request->getPost("group_leader_id")));
        }
        

        if (!$tb_user->save()) {
            $error="";
            foreach ($tb_user->getMessages() as $message) {
               $error.=$message.";";
            }

            return $this->redictAndforword(2,'error',$error,'/user/edit/'.$tb_user->getUserid(),[
                'controller' => "user",
                'action' => 'edit',
                'params' => [$tb_user->getUserid()]
            ]);
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'修改:'.$userId,
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));

        //清除用户列表缓存
        (new Userservice($this->di))->clearCacheByRedis();

        return $this->redictAndforword(1,'success','user was updated successfully','/user/index',[
            'controller' => "user",
            'action' => 'index'
        ]);

    }

    /**
     * Deletes a user
     *
     * @param string $userId
     */
    public function deleteAction($userId)
    {
        $tb_user = User::findFirstByuserId($userId);
        if (!$tb_user) {
            return $this->redictAndforword(1,'error','user was not found','/user/index',[
                'controller' => "user",
                'action' => 'index'
            ]);
        }

        $tb_user->setIsDelete(1);

        if (!$tb_user->save()) {
            $error='';
            foreach ($tb_user->getMessages() as $message) {
                $error.=$message.";";
            }
            return $this->redictAndforword(1,'error',$error,'/user/index',[
                'controller' => "user",
                'action' => 'index'
            ]);
        }

        //删除节点的话 下面的叶子都上面
        $groupleaderId=intval($tb_user->getGroupLeaderId());

        $tb_user_child=User::findByGroupLeaderId($userId);
        foreach($tb_user_child as $item){
            $item->setGroupLeaderId($groupleaderId);
            $item->save();
        }


        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'删除:'.$userId,
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_GET
            ));

        //清除用户列表缓存
        (new Userservice($this->di))->clearCacheByRedis();

        return $this->redictAndforword(1,'success','user was deleted successfully','/user/index',[
            'controller' => "user",
            'action' => 'index'
        ]);
    }


    private function getDeptOptions(){
       $list=(new Deptservice($this->di))->getDept();
     return    $this->setSelectOptions($list);
    }
    /*
     * 获取所有者列表
     */
    public function  allListAction(){
        $this->view->setLayout("common-iframe");

        $controller=$this->dispatcher->getControllerName();
        $action=$this->dispatcher->getActionName();


        $condition=array();
        $condtion_list=array();

       $dept= Dept::find();
       $list=array();
       foreach ($dept->toArray() as $v){
           $list[$v['dept_id']]=$v['name'];
       }


        $this->model['dept']['options']=$this->getDeptOptions();
        $this->model['parent_staff_seed']['show']=0;
        $this->model['mobile_phone']['show']=0;
        $this->model['user_role']['show']=0;
        $this->model['state']['show']=0;
        $this->model['updateTime']['show']=0;

        $dept_id=isset($_GET['dept_id'])?$_GET['dept_id']:0;

        if($dept_id>0){
            //获取所有子集
            $dept_ids= (new Deptservice($this->di))->getOneChind($dept_id);
            $dept_ids[]=$dept_id;
            $condition['dept']=array('type'=>'in');
            $condition['is_delete']=[];
            $condtion_list['dept']=$dept_ids;
            $condtion_list['is_delete']=0;

        }
        $numberPage = 1;
        $builder=  User::createBuiler('Zejicrm\Modules\Frontend\Models\User',$this->modelsManager,$condition,$condtion_list);
        $numberPage = $this->request->getQuery("page", "int");

        $urlstr='';
        //bind search value
        if(isset($parameters['bind'])){
            foreach ($parameters['bind'] as $k=>$v){
                $this->tag->setDefault($k,$_GET[$k]);
                if(empty($urlstr)){
                    $urlstr=$k.'='.urlencode($_GET[$k]);
                }else
                    $urlstr.='&'.$k.'='.urlencode($_GET[$k]);
            }
        }
        $this->view->setVar('urlstr',$urlstr);


        $paginator = new PaginatorQueryBuilder([
            "builder" => $builder,
            "limit"   => 20,
            "page"    => $numberPage
        ]);
        $list=  $paginator->getPaginate();
        $this->view->page = $list;


        $model=$this->defaultSettingModel($this->model);
        $this->view->models=$model;
    }

    public function myinfoAction(){
        $userId =$this->user_id;
        $this->model['dept']['show']=0;
        $this->model['dept']['role']=0;
        $this->model['dept']['role']=0;
        $this->editAction($userId);
        $this->view->setVar('treeId',6);
        $this->view->nodeName='myinfo';
    }


    public function changepassAction(){
         $model=array(
            'user_id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),
            'o_password'=>array('type'=>'password','lable'=>'老密码','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>0,'required'=>1,'rangelength'=>"[6,20]"),
            'new_password'=>array('type'=>'password','lable'=>'新密码','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>0,'required'=>1,'rangelength'=>"[6,20]"),
             'new_password_2'=>array('type'=>'password','lable'=>'新密码','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>0,'required'=>1,'rangelength'=>"[6,20]")
         );
        $model=$this->defaultSettingModel($model);
        $this->view->setVar('treeId',6);
        $this->view->nodeName='changepass';
        $this->view->models=$model;

    }

    public function changepassSaveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'index'
            ]);

            return;
        }

        $userId =$this->user_id;
//
//        //判断是不是 当前用户
//        if($this->user_id!=$userId){
//            die('invaild error');
//        }

        $tb_user = User::findFirstByuserId($userId);

        if (!$tb_user) {
            $this->flash->error("user does not exist " . $userId);

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'changepass',
                'params' => [$userId]
            ]);

            return;
        }

        $iserror=0;
        if($tb_user->getPassword()!=md5(trim($this->request->getPost("o_password")))){
            $error='原始密码错误！';
            $iserror=1;
        }elseif(trim($this->request->getPost("o_password"))==trim($this->request->getPost("new_password"))){
            $error='新密码和老密码相同！';
            $iserror=1;
        }
        elseif(trim($this->request->getPost("new_password_2"))!=trim($this->request->getPost("new_password"))){
            $error='两次输入的密码不符！';
            $iserror=1;
        }

        if($iserror==1){
            $this->flash->error($error);

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'changepass',
                'params' => [$userId]
            ]);

            return;
        }

        $tb_user->setPassword(md5($this->request->getPost("new_password")));
        $tb_user->setUpdateTime(time());

        if (!$tb_user->save()) {

            foreach ($tb_user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "user",
                'action' => 'changepass',
                'params' => [$tb_user->getUserid()]
            ]);

            return;
        }


        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'修改密码:'.$userId,
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>array(),
            ));

        $this->flash->success("密码已修改");

        $this->dispatcher->forward([
            'controller' => "user",
            'action' => 'changepass'
        ]);
        return;
    }


}
