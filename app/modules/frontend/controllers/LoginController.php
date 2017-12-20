<?php

namespace Zejicrm\Modules\Frontend\Controllers;

use Zejicrm\Modules\Frontend\Models\Resource;
use Zejicrm\Modules\Frontend\Models\Role;
use Zejicrm\Modules\Frontend\Models\User;
use Zejicrm\Modules\Frontend\Models\Userlog;
use Zejicrm\Userlogger;

class LoginController extends ControllerBase
{

    private  $roles=null;


    private function getAllRoles(){
       $roles =Role::find();
       $list=array();
        if($roles){
            foreach ($roles as $role){
                if($role->getRole()!='')
                  $list[$role->getRoleId()]=$role->getRole();
            }
        }
        return $list;
    }

    public function initialize()
    {
        $this->roles=$this->getAllRoles();
        parent::initialize();
    }

    public function indexAction()
    {
        if ($this->_isLogin()) {
            return  $this->response->redirect('/index/index');
        }

    }
    public function loginSubmitAction(){
        if ($this->request->isPost()) {

            // $type = $this->request->getPost('type');


            //Taking the variables sent by POST
//            $mobile = $this->request->getPost('mobile');
//            $email = $this->request->getPost('email');
            $account_id = $this->request->getPost('sub_account_id');
            $password = $this->request->getPost('password');
            $img_verity=$this->request->getPost('img_verity');
            //$res=$this->checkVerity($img_verity);
//            if(!$res){
//                $this->flash->error('验证码错误');
//                return $this->dispatcher->forward(array(
//                    'controller' => 'user',
//                    'action' => 'login'
//                ));
//            }
            $user=User::findFirstBySubAccountId($account_id);
            $isVerity=0;
            $error='账号不存在';

            if ($user) {
                if(intval($user->getIsLoginAllow())!=1){
                    $error='该账号已禁用';
                }elseif(intval($user->getState())!=2){
                    $error='该账号已禁用';
                }
                elseif(intval($user->getIsDelete())==1){
                    $error='账号不存在！';
                }
                elseif(md5($password)!=$user->getPassword()){
                    $error='密码错误！';
                }else{
                    $isVerity=1;
                }
            }

            if($isVerity==1){
                $this->_registerSession($user);
                $this->_registerCookie($user);
                //$this->cookies->set('role','Common',time()+86400,'/');
                $this->flash->success('Welcome ' . $user->getStaffName());

                //userlog
                $log_params=array(
                    'user_id'=>$user->getUserid(),
                    'user_name'=>$user->getStaffName(),
                    'action'=>1,
                    'remark'=>'登录',
                );
                (new Userlogger($this->di))->log(1,$log_params['remark'],$log_params);
                $user->setLogTimes(intval($user->getLogTimes())+1);
                $user->setLastLogTime(time());
                $user->save();
                return  $this->redictAndforword(1,'success','','/index/index');
            }else{
            //   return  $this->redictAndforword(1,'error',$error,'/login/index');
              return   $this->redictAndforword(2,'error',$error,'/login/index',array(
                    'controller' => 'login',
                    'action' => 'index'
                ));

            }
        }else{
            die('invaild error');
        }
    }



    public function loginoutAction()
    {
       $user= $this->session->auth;

        //userlog
        $log_params=array(
            'user_id'=>$this->user_id,
            'user_name'=>$this->nickname,
            'action'=>2,
            'remark'=>'登出',
        );
        (new Userlogger($this->di))->log(2,$log_params['remark'],$log_params);


        $this->_removeSession('auth');
        $this->_removeCookie();


        return  $this->response->redirect('/login/index');
        //return $this->dispatcher->forward(array("controller" => 'User', "action" => "login"));
    }



    private function _registerSession($user)
    {
        $auth_arr = $this->_combineAuth($user);
        $this->session->set('auth', $auth_arr);
    }

    private function _combineAuth($user)
    {
        return $auth_arr = array(
            'user_id' => $user->userId,
            'nickname' => $user->staff_name,
            'account_type' => $user->user_role,
            'sub_account_id' => $user->sub_account_id,
            'role' => $this->roles[$user->user_role],
        );
    }

    private function _registerCookie($user)
    {
        //$auth_arr=$this->_combineAuth($user);
        //return setcookie('auth',$auth_arr,time()+2*86400);
        $this->_setCookie('auth', $user->userId);
        $this->_setCookie('user_id', $user->userId);
        $this->_setCookie('role', $this->roles[$user->user_role]);
        $this->_setCookie('account_type', $user->user_role);
        $this->_setCookie('sub_account_id', $user->sub_account_id);
        $this->_setCookie('nickname', $user->staff_name);
        return true;
    }



    private function _removeSession($key)
    {
        $this->session->remove($key);
    }

    private function _destroySession()
    {
        $this->session->destroy();

    }

    private function _removeCookie()
    {
        $this->cookies->get('auth')->delete();
        $this->cookies->get('user_id')->delete();
        $this->cookies->get('role')->delete();
        $this->cookies->get('account_type')->delete();
        $this->cookies->get('nickname')->delete();
    }

}

