<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/5
 * Time: 14:58
 */
namespace Zejicrm;

use Zejicrm\Modules\Frontend\Models\Role;
use Zejicrm\Modules\Frontend\Models\Resource;

class AclEx {

    protected $_dependencyInjector;

    protected $acl_file="acl.json";

    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function makeFile(){
        $list=array(
            'Roles'=>[],
            'PrivateResources'=>[],
            'PublicResources'=>[],
            'PrivateAcl'=>[],
        );
        $roles=Role::find();
        $Resource=Resource::find();

        $private_source=array();
        $public_source=array();
        $all_source=array();
        $role_list=array();
        $prviate_acl=array();

        foreach ($roles as $role) {
//            echo $role->role_acl;
            if($role->role!=''){
                $role_list[$role->role]=$role->role;
                $role_acl=explode(',',$role->role_acl);
                $prviate_acl[$role->role]=explode(',',$role->role_acl);

                if(count($role_acl)>0){
                    $prviate_acl[$role->role]=$role_acl;
                }
            }
        }

        foreach ($Resource as $source){
            if($source->type==1){
                //public
                $public_source[$source->controller][]=$source->action;
            }else{
                //private
                $all_source[$source->id]=$source->toArray();
                $private_source[$source->controller][]=$source->action;
            }
        }


        foreach ($prviate_acl as $role =>$acl_list){
                $_list=array();
                foreach ($acl_list as $id){
                    if(isset($all_source[$id])){
                        $_list[$all_source[$id]['controller']][]=$all_source[$id]['action'];
                    }
                }
            $prviate_acl[$role]=$_list;
        }

        $list['Roles']=$role_list;
        $list['PrivateResources']=$private_source;
        $list['PublicResources']=$public_source;
        $list['PrivateAcl']=$prviate_acl;
//        var_dump($role_list);
//        var_dump($public_source);
//        var_dump($private_source);
//        var_dump($prviate_acl);
       return $this->_dependencyInjector['fileCache']->save($this->acl_file,json_encode($list),-1);
    }

    public function FileExist(){
        return  $this->_dependencyInjector['fileCache']->get($this->acl_file);
    }






}
