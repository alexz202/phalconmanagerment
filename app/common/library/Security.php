<?php
namespace Zejicrm;

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Config\Adapter\Json as configJson;
/**
 * Security
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class Security extends Plugin
{

    private $acl_config=null;

    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
        if(empty($this->acl_config)){
            $this->acl_config=$this->_dependencyInjector['aclJson']->toArray();
           // $this->acl_config=json_decode($this->_dependencyInjector['fileCache']->get('acl.json'),true);
        }
    }

    public function clearAcl(){
        $this->persistent->acl=null;
    }

    public function getAcl()
    {


        $acl_config=$this->getJson();
        $this->acl_config=$acl_config->toArray();

        if ($this->session->acl==null) {

            $acl = new Memory();

            $acl->setDefaultAction(Acl::DENY);

            //Register roles
            $roles =$this->getRoles();

            foreach ($roles as $role) {
                $acl->addRole($role);
            }


            //Private area resources
            $privateResources =$this->getPrivateResources();

            //Grant resources to role users
            $privateACL = $this->getPrivateAcl();

            $publicResources=$this->getPublicResources();

            foreach ($privateResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }
            //Public area resources

            foreach ($publicResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }
            //Grant access to public areas to both users and guests
            foreach ($roles as $role) {
                foreach ($publicResources as $resource => $actions) {
                    $acl->allow($role->getName(), $resource, $actions);
                }
            }
            //Grant acess to private area to role Users
            foreach ($privateACL as $roleUser => $privateResources) {
                foreach ($privateResources as $resource => $actions) {
                    foreach ($actions as $action) {
                        $acl->allow($roleUser, $resource, $action);
                    }
                }
            }
            //The acl is stored in session, APC would be useful here too
            $this->session->acl = $acl;
        }
        return $this->session->acl;
    }


    //从文件读取
    private function getRoles(){
//        return array(
//            'Common' => new Role('Common'),//普通用户
//            'Guests' => new Role('Guests'),//游客
//        );
        $roles=array();
        foreach ($this->acl_config["Roles"] as $key=>$role){
            $roles[$key]=new Role($role);
        }
        $roles['Guests']=new Role('Guests');
        return $roles;
    }

    private function getJson(){
        $aclJson= new configJson(BASE_PATH  . "/cache/acl.json");
        return $aclJson;
    }


    private function getPrivateResources(){
//        return $privateResources=array(
//            'user' => array('center','changeAvatar','changePassword','applyInvest','applyPerson','applyCompany','applyTest'),
//            'raise_funds'=>array('create'),
//
//        );
        return $this->acl_config["PrivateResources"];
    }

    private function getPublicResources(){
//        return   $publicResources = array(
//            'user' => array('register', 'login','loginSubmit','registerSubmit','loginout'),
//            'index' => array('index','test'),
////                'Index' => array('index'),
//        );
        return $this->acl_config["PublicResources"];
    }

    private function getPrivateAcl(){
//        return $privateACL=array(
//            'Common' => array(
//                'user' => array('center','changeAvatar','changePassword','applyInvest','applyPerson','applyCompany','applyTest'),
//            ),
//        );
       return $this->acl_config["PrivateAcl"];
    }



    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {

        if($this->config->application->user_login_form_cookies){
            //use cookies
            $auth=$this->_getCookie('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = $this->_getCookie('role');
            }

        }else{
            $auth = $this->session->get('auth');
//            $auth=$this->_getCookie('auth');
            if (!$auth) {
                $role = 'Guests';//default
            } else {
                $role =$auth['role'];
                // $role='Common';
            }
        }


        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);

        if($action=='loginout'){
            $this->session->acl=null;
        }

        if ($allowed != Acl::ALLOW) {
            if($this->request->isAjax()){
                echo "NoAuth";
                exit();
            }else{
                if($role=='Guests'){
                    $dispatcher->forward(
                        array(
                            'controller' => 'login',
                            'action' => 'index'
                        )
                    );
                }else{

                    $dispatcher->forward(
                        array(
                            'controller' => 'role',
                            'action' => 'notvisited'
                        )
                    );
                }
            }
            return false;
        }


    }

    private function _getCookie($key){
        if($this->cookies->has($key)){
            // 获取cookie
            $rememberMe = $this->cookies->get($key);

            // 获取cookie的值
            return   $value = $rememberMe->getValue();
        }
        else
            return false;
    }
}
