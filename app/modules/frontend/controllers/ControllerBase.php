<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Config\Adapter\Json as configJson;
use Phalcon\Http\Response;
use Zejicrm\Models\Base;
use Zejicrm\Modules\Frontend\Models\Role;
use Zejicrm\Modules\Frontend\Services\Customerservice;
use Zejicrm\Modules\Frontend\Services\Rolescreenservice;
use Zejicrm\Modules\Frontend\Services\Userservice;
use Zejicrm\Mylog;
use Zejicrm\Modules\Frontend\Services\Tongjiservice;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Zejicrm\ZlipToolkit;

class ControllerBase extends Controller
{

    protected  $dict=null;
    protected  $user_id=null;
    protected  $nickname=null;
    protected   $sub_account_id=null;
    protected $pagersize=50;
    protected $remote=0;
    protected $remote_server=null;
    /*
     * 获取字典值
    */
    public function getDictByStatic($key){
       return  $this->di['dictJson']->get($key);
    }

    protected function setValueToObj($obj,$func,$value,$isTime=0){
            if(isset($value)&&trim($value)!=''){
                if($isTime==1)
                    $obj->$func(strtotime($value));
                else
                     $obj->$func($value);
            }
    }

    protected function _exportAct(){
        $columns=$this->getColumnByCondition($this->model,'show');

        $this->view->setVar('columns',$columns);
        $this->view->setVar('model',$this->model);

        //设置门板打开方式
        $this->settingLayer();
        $link= $_GET['link'];
        $page=$_GET['page'];
        $total_items=$_GET['total_items'];
        $this->view->setVar('page',$page);
        $this->view->setVar('link',urldecode($link));
        $this->view->setVar('total_items',$total_items);
    }



    private function getYeildData($total_items,$step,$builder,$orderby){
        for($i=0;$i<=$total_items;$i+=$step){
            $limit= $step;
            $offset=$i;
            $builder->limit($limit,$offset);//数据量大限制导出本页数据
            $builder->orderBy($orderby);

            $result=$builder->getQuery()->execute();
            yield $data=$result->toArray();
        }

    }


    /*
     * 批量更新数据 如果是全部数据的话 要分段 如果是一页数据 直接修改
     */
    protected  function useMakeData($builder,$numberPage,$orderby,$useMakeType,$updateParams=array(),Customerservice $service){
       // $builder->columns("seed_id,customer_kind,is_delete");//指定参数有时候排序不对。
        $total_items=$_GET['total_items'];
        if($useMakeType==2){
            //更新一页
            $pagersize=isset($_GET['pagersize'])?intval($_GET['pagersize']):$this->pagersize;
            $limit=$pagersize;
            $offset=$pagersize*($numberPage-1);
            $builder->limit($limit,$offset);//数据量大限制导出本页数据
            $builder->orderBy($orderby);
            $result=$builder->getQuery()->execute();
            $data=$result->toArray();

            $ids=array();
            foreach ($data as $item) {
                $ids[]=intval($item['seed_id']);
            }
//            var_dump($builder->getPhql());
           return  $service->updateCustomerByIds(join(',',$ids),$updateParams);
        }else{

            //更新全部
            $step=10000;
            try{
                $j=0;
                $res=1;
                foreach ($this->getYeildData($total_items,$step,$builder,$orderby) as $data){
                    $j++;
                    $ids=array();
                    foreach ($data as $item) {
                        $ids[]=$item['seed_id'];
                    }
                    $res*=  $service->updateCustomerByIds(join(',',$ids),$updateParams);
                }

            }catch (\Exception $ex){
                echo $ex;
                $res=0;
            }finally{
                return $res;
            }
        }
    }

    private function mutipleUpdate($data){

    }



    //导出CSV统一处理方法
    protected function exportFunc($builder,$numberPage,$orderby,$tagall=0){
        //动态设定Export 字段
        if(isset($_GET['exCo'])){
            $columns=$_GET['exCo'];
        }
        $builder->columns($columns);
        $total_items=intval($_GET['total_items']);
        if($tagall==0||$total_items<10000){
            $limit= $this->pagersize;
            $offset=$this->pagersize*($numberPage-1);
            $builder->limit($limit,$offset);//数据量大限制导出本页数据
            $builder->orderBy($orderby);
            $result=$builder->getQuery()->execute();
            $data=$result->toArray();
            (new Mylog($this->di))->log($this->dispatcher->getActionName(),'导出',
                array(
                    'controll'=>$this->dispatcher->getControllerName(),
                    'userId'=>$this->user_id,
                    'username'=>$this->nickname,
                    "data"=>$_GET
                ));
            $this->exportOneCsv($data);
        }else{
            $step=10000;
            try{
                $j=0;
                $list=array();
                $tmpfolder="tmp".date('YmdHis').mt_rand(100,999);
                $path=BASE_PATH.'/files/'.$tmpfolder;
                mkdir($path);
                foreach ($this->getYeildData($total_items,$step,$builder,$orderby) as $data){
                    $j++;
                    $filename=$this->dispatcher->getControllerName().'_'.$this->dispatcher->getActionName()."_".$j;
                    $filename = sprintf("$filename-(%s).csv", date('Y-n-d'));
                    $res=$this->makeOneCsv($data,$path."/",$filename);
                    if($res)
                        $list[]=array('fullpath'=>$path."/".$filename,'filename'=>$filename);
                }
//                    $list[]=array('fullpath'=>$path,'filename'=>$filename);
            }catch (\Exception $ex){
                echo $ex;
            }finally{
                //打包输出文件
                $result=ZlipToolkit::toZip($list,$tmpfolder);
                if($result!=false){
                    (new Mylog($this->di))->log($this->dispatcher->getActionName(),'导出',
                        array(
                            'controll'=>$this->dispatcher->getControllerName(),
                            'userId'=>$this->user_id,
                            'username'=>$this->nickname,
                            "data"=>$_GET
                        ));
                    ZlipToolkit::download($result['fullpath'],$result['filename']);
                }

            }
        }
        exit();
    }


    //过滤导出字段
    private function filterExPortData($data){
        $list=[];
        if(count($data)>0) {
            $keys = array_keys($data[0]);
            foreach ($keys as $key) {
                $list['title'][] = $this->model[$key]['lable'];
            }
            $_data = [];
            foreach ($data as $item) {
                foreach ($item as $k => $v) {
                    $column_model = $this->model[$k];
                    if ($k != 'sub_account_id' && ($column_model['type'] == 'select' || $column_model['type'] == 'radio')) {
                        if (isset($column_model['options'][$v]))
                            $item[$k] = $column_model['options'][$v]['text'];
                        else
                            $item[$k] = $v;

                    } elseif ($column_model['type'] == 'time') {
                        $item[$k] = date('Y-m-d H:i:s', $v);
                    }
                }
                $_data[] = $item;
            }
            return array($list,$_data);
        }
        return array(false,false);
    }

    //导出CSV流文件
    private function exportOneCsv($data){
        list($list,$_data)=$this->filterExPortData($data);
        if($_data!=false){
            $this->exportExecel($this->dispatcher->getControllerName().'_'.$this->dispatcher->getActionName(),$list,$_data);
            $this->persistent->exportParams=null;
        }
    }


    //导出CSV流文件
    private function makeOneCsv($data,$path,$filename){
        list($list,$_data)=$this->filterExPortData($data);
        if($_data!=false){
            $res=$this->makeCsvFile($path,$filename,$list,$_data);
            return $res;
        }
    }


    protected function _index($model,$builerObj,$builerClassname,$selfCondition=array(),$orderbydefault="id desc",$filter=0,$exportType=1){
        $numberPage = 1;
        $numberPage = $this->request->getQuery("page", "int");
        $this->view->models=$model;
        //bind search value
        $columns=$this->getColumnByCondition($model,'show');

        $orderby=$this->request->getQuery("orderby");
        $_orderby=null;
        if(isset($orderby)){
            $_orderby=$orderby;
            $order=explode('-',$orderby);
            if($order[0]==1){
                $orderby="$order[1] asc";
            }else{
                $orderby="$order[1] desc";
            }
            $this->view->setVar("orderby_{$order[1]}",$order[0]);
        }
        else
            $orderby=$orderbydefault;


        //高级搜索
        list($gs_list,$condtion_list)= $this->filterGs($model,$_orderby);

        if(count($gs_list)>0){
            $condition=$gs_list;
        }else{
            list($condition,$condtion_list)=$this->buildSearch($model,$_orderby);
        }
        //合并手动指定的条件及值
        if(isset($selfCondition['condition'])){
            $condition=array_merge($condition,$selfCondition['condition']);
            $condtion_list=array_merge($condtion_list,$selfCondition['condition_list']);
        }

        if($filter==1)
        //根据角色过滤数据
            $roleParms=$this->getRoleDataParams();
        else
            $roleParms=array();

        $builder= Base::createBuiler($builerClassname,$this->modelsManager,$condition,$condtion_list,$orderby,$filter,$roleParms);


        //EXPORT FUNC
        if(isset($_GET['export'])){
            //Todo 动态设定Export 字段

            if(isset($_GET['exCo'])){
                $columns=$_GET['exCo'];
            }
            $builder->columns($columns);
            if($exportType==1){
                $limit= $this->pagersize;
                $offset=$numberPage*($this->pagersize-1);
                $builder->limit($limit,$offset);//数据量大限制导出本页数据
            }
            $result=$builder->getQuery()->execute();
            $data=$result->toArray();
            $list=array();

            (new Mylog($this->di))->log($this->dispatcher->getActionName(),'导出数据',
                array(
                    'controll'=>$this->dispatcher->getControllerName(),
                    'userId'=>$this->user_id,
                    'username'=>$this->nickname,
                    "data"=>$_GET
                ));

            if(count($data)>0){
                $keys=array_keys($data[0]);
                foreach ($keys as $key){
                    $list['title'][]=$this->model[$key]['lable'];
                }


                $_data=[];
                foreach ($data as $item){
                    foreach ($item as $k=>$v){
                        $column_model=$this->model[$k];
                        if($k!='sub_account_id'&&($column_model['type']=='select'||$column_model['type']=='radio')){
                            if(isset($column_model['options'][$v]))
                                $item[$k]=$column_model['options'][$v]['text'];
                            else
                                $item[$k]=$v;

                        }elseif($column_model['type']=='time'){
                            $item[$k]= date('Y-m-d H:i:s',$v);
                        }
                    }
                    $_data[]=$item;
                }

                self::exportExecel($this->dispatcher->getControllerName().'_'.$this->dispatcher->getActionName(),$list,$_data);
                $this->persistent->exportParams=null;
            }
            exit();
        }else{
            $paginator = new PaginatorQueryBuilder([
                "builder" => $builder,
                "limit"   => $this->pagersize,
                "page"    => $numberPage
            ]);
            $list=  $paginator->getPaginate();
            $this->view->page = $list;

            (new Mylog($this->di))->log($this->dispatcher->getActionName(),'访问：',
                array(
                    'controll'=>$this->dispatcher->getControllerName(),
                    'userId'=>$this->user_id,
                    'username'=>$this->nickname,
                    "data"=>$_GET
                ));
        }
    }

    protected function _createSave($obj,$errorAction,$successAction,$type=0){
        if (!$obj->save()) {
            $error='';
            foreach ($obj->getMessages() as $message) {
                //$this->flash->error($message);
                $error.=$message.';';
            }

            return $this->redictAndforword(2,'error','','/customer/new',[
                'controller' => $this->dispatcher->getControllerName(),
                'action' => $errorAction
            ]);
        }


        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'创建',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));
        $url='/'.join('/',[$this->dispatcher->getControllerName(),$successAction]);

        return $this->redictAndforword(1,'success','添加成功',$url,[
            'controller' => $this->dispatcher->getControllerName(),
            'action' => $successAction
        ]);
    }

    protected  function _update($obj,$psId,$errorAction,$successAction){
        if (!$obj->save()) {

            $error='';
            foreach ($obj->getMessages() as $message) {
                //$this->flash->error($message);
                $error.=$message.';';
            }

            return $this->redictAndforword(2,'error',$error,"/{$this->dispatcher->getControllerName()}/edit/{$psId}",  [
                'controller' =>  $this->dispatcher->getControllerName(),
                'action' => 'edit',
                'params' => [$psId]
            ]);
        }

        $url='/'.join('/',[$this->dispatcher->getControllerName(),$successAction]);

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'修改',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));


        return $this->redictAndforword(1,'success','添加成功',$url,[
            'controller' => $this->dispatcher->getControllerName(),
            'action' => $successAction
        ]);

    }

    public function redictAndforword($type=1,$func='success',$message,$url='',$params=array(),$ajaxData=array()){
        //如果是异步的话 直接返回
        if($this->request->isAjax()){
            if($func=='success')
                $this->createJsonReturn(1,$message,$ajaxData);
            else
                $this->createJsonReturn(0,$message,$ajaxData);
        }

        if($type==1){
                $this->flashSession->clear();
                $this->flashSession->$func($message);
                return $this->response->redirect($url);
        }else{
                $this->flash->$func($message);
                return $this->dispatcher->forward($params);
        }
    }

    /*
     * 数据库配置的
     */
    public function getDict($key){
        $list= new configJson(BASE_PATH  . "/cache/dict.json");
        $list= $list[$key];
        return $list->toArray();
    }


    /*
   *获取model配置文件
   */
    public function getModel($controller){
        $list= new configJson(BASE_PATH  . "/cache/columns.json");
        $list= $list[$controller];
        if(isset($list)){
            $list=$list->toArray();
            //TODO 根据ROLE 合并展示的内容
            if($controller=='customer' || $controller=="customerfollow" || $controller=="order"){
                $role_id=$this->_getRoleId();
                if(!empty($role_id)){
                    $m_list=(new Rolescreenservice($this->di))->getShowColumnsByController($controller,$role_id);
                    if($m_list){
                        $m_list=$m_list->toArray();
                    }

                    $key_merge_list=array();

                    if(isset($m_list)){
                        foreach ($m_list as $v){
                            $key_merge_list[$v['key']]=$v;
                        }

                        foreach ($list as $k=>&$v){
                            if(isset($key_merge_list[$k])){
                                $v=array_merge($v,$key_merge_list[$k]);
                            }
                        }
                    }
                }
            }
            return $list;
        }
        else
            return array();
    }




    public function createJsonReturn($code=0,$msg='',$data=array()){
        echo json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$data));
        exit();
    }



    public function initialize(){
        $this->remote=$this->di['config']->source_service->remote;
        $this->remote_server=$this->di['config']->source_service->remote_server;
        $this->view->setVar('remote',$this->remote);
        $this->view->setVar('remote_server',$this->remote_server);
        if($this->config->application->user_login_form_cookies){
            $auth=$this->_getCookie('auth');
            if (!$auth) {
                $this->view->setVar('isLogin',0);
            } else {
                $nickname = $this->_getCookie('nickname');
                $account_type = $this->_getCookie('account_type');
                $user_id= $this->_getCookie('user_id');
                $sub_account_id= $this->_getCookie('sub_account_id');
                $this->view->setVar('isLogin',1);
                $this->view->setVar('nickname',$nickname);
                $this->view->setVar('account_type',$account_type);
                $this->view->setVar('user_id',$user_id);
                $this->user_id=$user_id;
                $this->nickname=$nickname;
                $this->sub_account_id=$sub_account_id;
            }
        }else{
            $auth = $this->session->get('auth');
            if (!$auth) {
                $this->view->setVar('isLogin',0);
            } else {
                $role =$auth['role'];
                $nickname = $auth['nickname'];
                $account_type =$auth['account_type'];
                $user_id= $auth['user_id'];
                $sub_account_id=$auth['sub_account_id'];
                $this->view->setVar('isLogin',1);
                $this->view->setVar('nickname',$nickname);
                $this->view->setVar('account_type',$account_type);
                $this->view->setVar('user_id',$user_id);
                $this->user_id=$user_id;
                $this->nickname=$nickname;
                $this->sub_account_id=$sub_account_id;
            }
        }

    }

    public function _getRoleId(){
        if($this->config->application->user_login_form_cookies){
            $auth=$this->_getCookie('auth');
        }else{
            $auth = $this->session->get('auth');
        }

        if($auth)
            return intval($auth['account_type']);
        else
            return 0;
    }

    public function _isLogin(){
        if($this->config->application->user_login_form_cookies){
            $auth=$this->_getCookie('auth');
            if (!$auth) {
                return false;
            } else {
                return true;
            }
        }else{
            $auth = $this->session->get('auth');
//            $auth=$this->_getCookie('auth');
            if (!$auth) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function _setCookie($key,$value){
        $this->cookies->set($key,$value, time()+$this->config->application->cookie_remember_timeout);
    }

    public function _getCookie($key){
        if($this->cookies->has($key)){
            // 获取cookie
            $rememberMe = $this->cookies->get($key);

            // 获取cookie的值
            return   $value = $rememberMe->getValue();
        }
        else
            return false;
    }

    protected function defaultSettingModel($model,$sort=0){
        $sort_list=array();
        $_model=array();
        foreach ($model as $k=>$v){
            $func_v='get_'.$k;
            $func_v=$this->convertUnderline($func_v)."()";
            if(!isset($v)){
                $v['func']=$func_v;
                $model[$k]=array_merge($v,$this->default_model['default']);
            }
            else{
                $diff_keys= array_diff(array_keys($this->default_model['default']),array_keys($v));
                foreach ($diff_keys as $key) {
                    $v[$key]=$this->default_model['default'][$key];
                }
                $v['func']=$func_v;
                $model[$k]=$v;
            }
            if($v['ispk']==1)
                $sort_list[]=array('sort'=>99999,'key'=>$k);//主键排最前面
            else
                $sort_list[]=array('sort'=>$model[$k]['sort'],'key'=>$k);
        }

        //排序
        if($sort==1){
            usort($sort_list,array($this,'sortF'));
            foreach ($sort_list as $v){
                $key=$v['key'];
                $_model[$key]=$model[$key];
            }
        }else{
            $_model=$model;
        }

        return $_model;
    }


    private function sortF($a,$b){
        return $a['sort']<$b['sort'];

    }
    /**
     * @var array
     *
     *  @tag 首页 展开关键字
     *
     *  @search 普通搜索
     *      qt:"=","like",...
     *      type:and in or between
     *
     *  @自定义搜索
     *  gsSearchOptions 高级搜索条件
     *      qt:"=","like",...
     *      type:and in between|or
     *
     *
     *
     */
    private $default_model=array(
        'default'=>array('type'=>'text','show'=>1,'lable'=>'','ispk'=>0,'edit'=>1,'detail'=>1,'ispk'=>0,'search'=>0,'gassearch'=>0,'create'=>0,'detail'=>0,'orderby'=>0,'searchOptions'=>array(
            'qt'=>'=',
            'type'=>"and",
        ),"gsSearchOptions"=>array(
            'qt'=>['=','like'],
            'type'=>['and'],
        ),'tag'=>0,'required'=>0,'sort'=>0,'rangelength'=>null,'email'=>0,'number'=>0,'mutiUpdate'=>0),
    );

    private function convertUnderline($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i',function($matches){
            return strtoupper($matches[2]);
        },$str);
        return $str;
    }


    public  function exportExecel($filename,$info,$data){
        $str=join(',',array_values($info['title']))."\r\n";
        $results=array();
        foreach ($data as $v){
            $results[]=join(',',array_values($v));
        }

        $str .= implode("\r\n", $results);
        $str = chr(239).chr(187).chr(191).$str;
        $filename = sprintf("$filename-(%s).csv", date('Y-n-d'));
        $response = new Response();
        $response->setHeader('Content-type', 'text/csv');
        $response->setHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');
        $response->setHeader('Content-length', strlen($str));
        $response->setContent($str);
        $response->send();
        return $response;
    }


    public function makeCsvFile($path,$filename,$info,$data){
        $str=join(',',array_values($info['title']))."\r\n";
        $results=array();
        foreach ($data as $v){
            $results[]=join(',',array_values($v));
        }

        $str .= implode("\r\n", $results);
        $str = chr(239).chr(187).chr(191).$str;
        file_put_contents($path.$filename,$str);
        return array($path,$filename);
    }


    protected function settingLayer(){
        //设置门板打开方式
        if($this->request->isAjax()){
            $this->view->setLayout("common-layer");

            $controller=$this->dispatcher->getControllerName();
            $action=$this->dispatcher->getActionName();

            $this->view->setMainView($controller.'/'.$action.'-layer');
        }
    }

    public function setSelectOptions($list,$default_parms=array()){
        $selectOptions=array();
        $i=0;
        if(count($default_parms)>0)
            foreach ($default_parms as $k =>$v){
                if($i==0)
                    $selected=1;
                else
                    $selected=0;
                $selectOptions[$k]=array(
                    'text'=>$v,
                    'selected'=>$selected,
                );
                $i++;
            }

        foreach ($list as $k=>$v){
            if($i==0)
                $selected=1;
            else
                $selected=0;
            $selectOptions[$k]=array(
                'text'=>$v,
                'selected'=>$selected,
            );
            $i++;
        }

        return $selectOptions;

    }

    public function setValueToKey($list){
        $_list=[];
        foreach ($list as $k=>$v){
            $_list[$v]=$k;
        }
        return $_list;
    }


    public function setSuggestOptions($list,$default_parms=array()){
        $selectOptions=array();
        $i=0;

        if(count($default_parms)>0){
            foreach ($default_parms as $k =>$v){
                $selectOptions[$k]=array(
                    'id'=>$k,
                    'name'=>$v,
                );
                $i++;
            }
        }

        foreach ($list as $k=>$v){
            $selectOptions[]=array(
                'id'=>$k,
                'name'=>$v,
            );
            $i++;
        }
        return $selectOptions;

    }


    //获取某熟悉所有键名  show=1;
    public function getColumnByCondition($model,$condition){
        $list=array();
        foreach ($model as $k=>$v){
            if($v[$condition]==1){
                $list[]=$k;
            }
        }
        return $list;
    }

    /*
 * 构建search 条件
 */
    public function buildSearch($model,$orderby,$isMutiple=0){
        $condition=[];
        $condition_list=[];
        $urlstr="";
        $searchKey="";

        foreach ($_GET as $k=>$v){
            if($v!=null && isset($model[$k])){
                $mode=$model[$k];
                if($mode['search']==1 || $mode['tag']==1){
                    if($isMutiple==0){
                        $searchKey=$k;
                    }
                    $condition[$k]=$mode['searchOptions'];
                    if($mode['type']=='time'){
                        if($mode['searchOptions']['type']=='between'){
                            if(is_array($_GET[$k])){
                                $this->tag->setDefault($k,join(',',$_GET[$k]));
                                $value=join(',',$_GET[$k]);
                            }else{
                                $this->tag->setDefault($k,$_GET[$k]);
                                $value=$_GET[$k];
                            }
                            $condition_list[$k]=$this->filterTimeBetween($_GET[$k]);
                        }else{
                            $this->tag->setDefault($k,strtotime($_GET[$k]));
                            $condition_list[$k]=strtotime($v);
                            $value=$_GET[$k];
                        }
                    }else{
                        $this->tag->setDefault($k,$_GET[$k]);
                        $condition_list[$k]=$v;
                        $value=$_GET[$k];
                    }
                    if(empty($urlstr)){
                        $urlstr=$k.'='.urlencode($value);
                    }else
                        $urlstr.='&'.$k.'='.urlencode($value);
                }
            }
        }

//        var_dump($urlstr);
//        die();
        if(isset($orderby)){
            if(empty($urlstr)){
                $urlstr='orderby='.urlencode($orderby);
            }else
                $urlstr.='&orderby='.urlencode($orderby);
        }

        $urlnopagersize=$urlstr;
        $pagersize=$this->pagersize;

        if(isset($_GET['pagersize'])){
            if(empty($urlstr)){
                $urlstr='pagersize='.urlencode($_GET['pagersize']);
            }else
                $urlstr.='&pagersize='.urlencode($_GET['pagersize']);
            $pagersize=$_GET['pagersize'];
        }

        $this->view->setVar('urlstrnopagersize',$urlnopagersize);
        $this->view->setVar('pagersize',$pagersize);

        $this->view->setVar('urlstr',$urlstr);
        //prov city 一直联动
        if($searchKey=='city')
            $searchKey='province';
        $this->view->setVar('searchKey',$searchKey);
        return [$condition,$condition_list];
    }

    /*
     * 构建高斯搜索
     */

    public function filterGs($model,$_orderby){
        $columns=$this->getColumnByCondition($model,'gassearch');
        $list=[];
        $list_value=[];
        $urlstr='';
        foreach ($columns as $key){
            if(isset($_GET['gs-'.$key])&&(!empty($_GET['gs-'.$key]) ||$_GET['gs-'.$key]!=null ||$_GET['gs-'.$key]!='') ){
                $ismu=0;
                if(count($model[$key]['gsSearchOptions']['qt'])>1){
                    //有多个QT的话 要获取QT
                    $qt=$_GET['qt-'.$key];
                    $ismu=1;
                }else{
                    $qt='=';
                }


                if($model[$key]['gsSearchOptions']['type'][0]=='in'){
                    $type='in';

                }elseif($model[$key]['gsSearchOptions']['type'][0]=='between'){
                    $type='between';
                }else{
                    $type='and';
                }
                $list[$key]= array(
                    'type'=>$type,
                    'qt'=>$qt,
                );

                if($model[$key]['type']=='time'){
                    $list_value[$key]=$this->filterTimeBetween($_GET['gs-'.$key]);
                }else
                    $list_value[$key]=$_GET['gs-'.$key];

                if(is_array($_GET['gs-'.$key])){
                    $value=join(',',$_GET['gs-'.$key]);
                }else{
                    $value=trim($_GET['gs-'.$key]);
                }

                if(empty($urlstr)){
                    $urlstr='gs-'.$key.'='.urlencode($value);

                }else{
                    $urlstr.='&gs-'.$key.'='.urlencode($value);

                }
                if($ismu==1){
                    $urlstr.='&qt-'.$key.'='.urlencode($_GET['qt-'.$key]);
                }

            }

        }
        if(isset($orderby)){
            if(empty($urlstr)){
                $urlstr='orderby='.urlencode($orderby);
            }else
                $urlstr.='&orderby='.urlencode($orderby);
        }

        $urlnopagersize=$urlstr;
        if(isset($_GET['pagersize'])){
            if(empty($urlstr)){
                $urlstr='pagersize='.urlencode($_GET['pagersize']);
            }else
                $urlstr.='&pagersize='.urlencode($_GET['pagersize']);
            $pagersize=$_GET['pagersize'];
        }else{
            $pagersize=$this->pagersize;
        }

        $this->view->setVar('urlstr',$urlstr);

        $this->view->setVar('urlstrnopagersize',$urlnopagersize);
        $this->view->setVar('pagersize',$pagersize);

        return array($list,$list_value);
    }

    private function filterTimeBetween($value){
        $arr=[];
        if(is_array($value)){
            $arr=$value;
        }else{
            $arr=explode(',',$value);
        }

        if(isset($arr[0])&&trim($arr[0])!=''){
            $v_1=strtotime($arr[0]);
        }else{
            $v_1='';
        }


        if(isset($arr[1])&&trim($arr[1])!=''){
            $v_2=strtotime($arr[1]);
        }else{
            $v_2='';
        }
        return [$v_1,$v_2];
    }


    /*
 *
 * 所有者信息 1 key=sub_account_id 2 key =user_id
 */
    public function getAccountIdList($type=1){
        $list=array();
        $users=(new Userservice($this->di))->getAllUserByNameSort();
     //   $users= (new Userservice($this->di))->getAllUser();
        foreach ($users as $user){
            if($type==1)
              $list[$user['sub_account_id']]=$user['staff_name'];
            else{
                $list[$user['user_id']]=$user['staff_name'];
            }

        }

        return  $list;
    }

    //subaccountId to userId
    public function getSubAccountToUserIdList(){
        $list=array();
        $users= (new Userservice($this->di))->getAllUser();
        foreach ($users as $user){
                $list[$user['sub_account_id']]=$user['user_id'];
        }
        return  $list;
    }

    //subaccountId to userId
    public function getStaffNameToUserIdList()
    {
        $list = array();
        $users = (new Userservice($this->di))->getAllUser();
        foreach ($users as $user) {
            $list[$user['staff_name']] = array('user_id'=>$user['user_id'],'sub_account_id'=>$user['sub_account_id']);
        }
        return $list;
    }

        /*
         * 获取所有子IDS包括自己
         */
    protected function getAllchildIds($user_id){
      $ids=  (new Userservice($this->di))->getOneGroupChild($user_id,1);
      return array_merge([(string)$user_id],$ids);
    }


    //根据角色过去数据过滤信息
    protected function getRoleDataParams(){
        $params=array('data_level'=>2,'data_user_ids'=>[],'s_data_user_ids'=>[]);
        $role_id=$this->_getRoleId();
        if(intval($role_id>0)){
            $role=Role::findFirstByRoleId($role_id);
            if($role){
                $data_level=intval($role->getDataLevel());
                $s_data_group_id= $role->getSDataGroupId();
                $params['data_level']=$data_level;
                if($data_level!=1){
                    //如果不是组长的话 只能看到自己的
                    $params['data_user_ids']=$this->getAllchildIds(intval($this->user_id));
                }
                if($s_data_group_id){
                    $s_data_group_id=json_decode($s_data_group_id,true);
                    $s_data_user_ids=[];
                    foreach ($s_data_group_id as $v){
                        if($v==0){
                            break;
                        }
                        $s_data_user_ids=array_merge($s_data_user_ids,$this->getAllchildIds($v));
                    }
                    $params['s_data_user_ids']=array_unique($s_data_user_ids);
                }
            }
        }
        return $params;
    }


    protected function get_week($year) {
        $year_start = $year . "-01-01";
        $year_end = $year . "-12-31";
        $startday = strtotime($year_start);
        if (intval(date('N', $startday)) != '1') {
            $startday = strtotime("next monday", strtotime($year_start)); //获取年第一周的日期
        }
        $year_mondy = date("Y-m-d", $startday); //获取年第一周的日期

        $endday = strtotime($year_end);
        if (intval(date('W', $endday)) == '7') {
            $endday = strtotime("last sunday", strtotime($year_end));
        }
        $num = intval(date('W', $endday));
        $nowWeek=intval(date('W'));
        for ($i = 1; $i <= $num; $i++) {
            $j = $i -1;
            $start_day = date("Y-m-d", strtotime("$year_mondy $j week "));
            $end_day = date("Y-m-d", strtotime("$start_day +6 day"));

            if($i<=$nowWeek){
                $week_array[$year.'-'.sprintf("%02d",$i)] ="第{$i}周:".$start_day."~~".$end_day;
            }
        }
        return $week_array;
    }

}
