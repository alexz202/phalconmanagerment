<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Config\Adapter\Json as configJson;
use Phalcon\Http\Response;
use Zejicrm\BeanstalkToolkit;
use Zejicrm\Log;
use Zejicrm\Models\Base;
use Zejicrm\Modules\Frontend\Models\Customer;
use Zejicrm\Modules\Frontend\Models\Role;
use Zejicrm\Modules\Frontend\Models\User;
use Zejicrm\Modules\Frontend\Services\Customerservice;
use Zejicrm\Modules\Frontend\Services\Hrbaseservice;
use Zejicrm\Modules\Frontend\Services\Rolescreenservice;
use Zejicrm\Modules\Frontend\Services\Userservice;
use Zejicrm\Mylog;
use Zejicrm\Modules\Frontend\Services\Tongjiservice;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Zejicrm\ZlipToolkit;
use Zejicrm\Util;
use Zejicrm\Sign;
use Zejicrm\Phpqrcode\phpqrcode;
use Zejicrm\Source;




class ControllerBase extends Controller
{
    protected  $dict=null;
    protected  $user_id=null;
    protected  $nickname=null;
    protected  $sub_account_id=null;
    protected  $role_id=null;
    protected $pagersize=50;
    protected $treeSuffix='';
    private $sysChild=1;
    protected $is_duty_sales=0;
    protected $is_duty_service_staff=0;
    protected $is_duty_hr=0;

    const DEFAULT_SUB_ACCOUNT_ID='zejicc22';
    const DEFAULT_USER_ID=61;
    const SOURCE_EDP=27;
    const SOURCE_CBT=26;
    const SOURCE_WEB_SHOP=28;
    const SOURCE_LIVE_ORDER=30;
    const SOURCE_MARKET_ACTIVITY=31;
    const COMMON_DATA_RALATION_KEY='user_id';
    const SERVICE_DATA_RALATION_KEY='service_user_id';
    const SERVICE_DATA_RALATION_SINGLE_KEY='single_service_user_id';
    const DEFAULT_XUEFU_MANAGER_USER_ID=73;
    const DEFALUT_DATACOLLECT_MANAGER_EMAIL=["2853618857@qq.com"=>"许丽军"];
  //  const DEFALUT_XUEFU_MANAGER_EMAIL=["wuzhejun@zejifinance.com"=>"吴喆钧","2850876199@qq.com"=>"张会杰"];
    const DEFALUT_XUEFU_MANAGER_EMAIL=["2851575267@qq.com"=>"吴喆钧","2850876199@qq.com"=>"张会杰"];
    const DEFALUT_ACCOUNT_MANAGER_EMAIL=["2850876192@qq.com"=>"裘峥嵘"];
    const DEFALUT_GET_INVOICE_EMAIL=["2850876210@qq.com"=>"李涛","2851575270@qq.com"=>'钟妙晴'];

    const CUSTOMER_KIND_POTENTIAL=1;//潜在
    const CUSTOMER_KIND_SUCCESS=2;//成功
    const CUSTOMER_KIND_PUBLIC=0;//公海
    const CUSTOMER_KIND_DEPOSIT=4;//定金

    const PAY_TYPE_BY_ALLFEE=7;//全款
    const PAY_TYPE_BY_STAGES=8;//全款
    const PAY_TYPE_BY_DEPOSIT=9;//全款
    const SHU_DEPT_ROLE_ID=87;//数据部
    const SUPER_ADMIN_ROLE_ID=1;//超级管理员
    const SALES_MASTER_ROLE_ID=98;//销售总监
    const CC_MASTER_ROLE_ID=31;//销售经理

    private $bnstalkd_Can_Conn=0;



    protected $invoiceType_dict=array('1'=>'普通发票','4'=>'增值税普通发票','2'=>'增值税专用发票','3'=>'财大收据');
    /*
     * 获取字典值
    */
    public function getDictByStatic($key){
       return  $this->di['dictJson']->get($key);
    }

    /*
     * 0:string 1:time 2:array
     */
    protected function setValueToObj($obj,$func,$value,$isType=0){
        if(is_array($value)||$isType==2){
            if(!empty($value))
                $obj->$func($value);
            else
                $obj->$func('');
        }else{
            if(isset($value)&&trim($value)!=''){
                if($isType==1){
                    if(strtotime(trim($value))>0)
                        $obj->$func(strtotime(trim($value)));
                }
                else
                    $obj->$func(trim($value));
            }
        }
    }

    protected function setValueToObjKey($obj,$key,$value,$isType=0){
        if(!empty($value)){
            if($isType==1)
                $value=strtotime($value);
            $obj->$key=$value;
        }
    }

    protected function _exportAct($other_columns = []){
        $columns=$this->getColumnByCondition($this->model,'show');
        if( $other_columns ){
            $columns = array_merge($columns,$other_columns);
        }
        $this->view->setVar('columns',$columns);
        $this->view->setVar('model',$this->model);

        //设置门板打开方式
        $this->settingLayer();
//        $link= $_GET['link'];

        $page=$_GET['page'];
        $total_items=$_GET['total_items'];
        $this->view->setVar('page',$page);
//        $this->view->setVar('link',urldecode($link));
        $this->view->setVar('total_items',$total_items);
    }



    private function getYeildData($total_items,$step,$builder,$orderby,$tableJoin=0,$extraParams=[]){
        for($i=0;$i<=$total_items;$i+=$step){
            $limit= $step;
            $offset=$i;
            $builder->limit($limit,$offset);//数据量大限制导出本页数据
            $builder->orderBy($orderby);
            $result=$builder->getQuery()->execute();
            if($tableJoin==1){
                $columns=$extraParams['columns'];
                $exportOther=$extraParams['exportOther'];
                yield $this->_parseJoinResultToExport($result,$columns,$exportOther);
            }else{
                yield $data=$result->toArray();
            }
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

    /*
   * 批量更新数据 如果是全部数据的话 要分段 如果是一页数据 直接修改
   */
    protected  function useMakeDataCommon($builder,$numberPage,$orderby,$useMakeType,$updateParams=array(),$service){
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
                $ids[]=intval($item['id']);
            }
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
                        $ids[]=$item['id'];
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


    private function _parseJoinResultToExport($result,$columns,$exportOther){
        //如果是跨表的话
        $data=[];
        $i=0;
        $columsIndex=explode(',',$columns);
        foreach($result as $obj){
            foreach ($columsIndex as $v){
                if(!empty(trim($v))){
                    $data[$i][trim($v)]=$obj->$v;
                }
            }
            foreach ($exportOther['tableJoin'] as $k=>$v){
                eval("\$data[\$i][\$k]=".$v);
            }
            $i++;
        }
        return $data;
    }

    //导出CSV统一处理方法
    protected function exportFunc($builder,$numberPage,$orderby,$tagall=0,$exportOther=[]){
        //动态设定Export 字段
        if(isset($_GET['exCo'])){
            $columns=$_GET['exCo'];
            if( !empty($exportOther)&&isset($exportOther['key'])){
                $columns = str_replace($exportOther['key'],"",$columns);
                $columns = trim($columns,',');
            }
        }
        $tableJoin=0;
        $extraParams=['columns'=>$columns,'exportOther'=>$exportOther];
        if(isset($exportOther['tableJoin'])){
            $tableJoin=1;
        }else{
           $builder->columns($columns);
        }
        $total_items=intval($_GET['total_items']);
        if($tagall==0||$total_items<10000){
//             $limit= $this->pagersize;
//            $offset=$this->pagersize*($numberPage-1);
            $builder->limit($total_items,0);//数据量大限制导出本页数据
            $builder->orderBy($orderby);
            $result=$builder->getQuery()->execute();
            if($tableJoin==0){
                $data=$result->toArray();
            }else{
                //跨表
                $data=$this->_parseJoinResultToExport($result,$columns,$exportOther);
            }
            (new Mylog($this->di))->log($this->dispatcher->getActionName(),'导出',
                array(
                    'controll'=>$this->dispatcher->getControllerName(),
                    'userId'=>$this->user_id,
                    'username'=>$this->nickname,
                    "data"=>$_GET
                ));
            $this->exportOneCsv($data,$exportOther);
        }else{
            $step=10000;
            try{
                $j=0;
                $list=array();
                $tmpfolder="tmp".date('YmdHis').mt_rand(100,999);
                $path=BASE_PATH.'/public/files/export/'.$tmpfolder;
                mkdir($path);
                foreach ($this->getYeildData($total_items,$step,$builder,$orderby,$tableJoin,$extraParams) as $data){
                    $j++;
                    $filename=$this->dispatcher->getControllerName().'_'.$this->dispatcher->getActionName()."_".$j;
                    $filename = sprintf("$filename-(%s).csv", date('Y-n-d'));
                    $res=$this->makeOneCsv($data,$path."/",$filename,$exportOther);
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
    private function filterExPortData($data,$exportOther){
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
                    if ($k=='sub_account_id'|| $column_model['type'] == 'select' || $column_model['type'] == 'radio') {
                        if (isset($column_model['options'][$v]))
                            $item[$k] = $column_model['options'][$v]['text'];
                        else
                            $item[$k] = $v;

                    } elseif ($column_model['type'] == 'time') {
                        $item[$k] = date('Y-m-d H:i:s', $v);
                    }elseif($column_model['type'] == 'day'){
                        $item[$k] = date('Y-m-d', $v);
                    }elseif($column_model['type'] == 'textarea'){
                        $item[$k] ='"'.$v.'"';
                    }
                    if(!empty($exportOther)&&isset($exportOther['reKey'])){
                        if( $k == $exportOther['reKey'] ){
                            $item[$exportOther['key']] = $exportOther['list'][$item[$k]];
                        }
                    }
                    //订单主题过滤
                    if(isset($column_model['clamp_order_subject'])&&$column_model['clamp_order_subject']==1){
                        $item[$k] =$this->_filterOrderSubject($v);
                    }
                }
                $_data[] = $item;
            }
            if(!empty($exportOther)&&isset($exportOther['title'])){
                $list['title'][] = $exportOther['title'];
            }
            return array($list,$_data);
        }
        return array(false,false);
    }

    //导出CSV流文件
    private function exportOneCsv($data,$exportOther){
        list($list,$_data)=$this->filterExPortData($data,$exportOther);
        if($_data!=false){
            $this->exportExecel($this->dispatcher->getControllerName().'_'.$this->dispatcher->getActionName(),$list,$_data);
            $this->persistent->exportParams=null;
        }
    }


    //导出CSV流文件
    private function makeOneCsv($data,$path,$filename,$exportOther){
        list($list,$_data)=$this->filterExPortData($data,$exportOther);
        if($_data!=false){
            $res=$this->makeCsvFile($path,$filename,$list,$_data);
            return $res;
        }
    }

    /*通用函数
     *
     */
    protected function _index($model,$builerObj,$builerClassname,$selfCondition=array(),$orderbydefault="id desc",$filter=0,$exportType=1,$useMakeType=0,$updateParams=[],$service=null,$filterKey='user_id',$exportOther=[]){
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

        $builder= Base::createBuiler($builerClassname,$this->modelsManager,$condition,$condtion_list,$orderby,$filter,$roleParms,$filterKey);
        //EXPORT FUNC
        if(isset($_GET['export'])){
            //Todo 动态设定Export 字段
            $this->exportFunc($builder,$numberPage,$orderby,1,$exportOther);
        }
        elseif($useMakeType>0){
            //批量更新字段
            return $this->useMakeDataCommon($builder,$numberPage,$orderby,$useMakeType,$updateParams,$service);
        }
        else{
            $paginator = new PaginatorQueryBuilder([
                "builder" => $builder,
                "limit"   => isset($_GET['pagersize'])?$_GET['pagersize']:$this->pagersize,
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
        $builder->list = $list->items->toArray();
        return $builder;
    }

    protected function _createSave($obj,$errorAction,$successAction,$type=0,$needRedict=1){
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

        if($needRedict==1){
            $url='/'.join('/',[$this->dispatcher->getControllerName(),$successAction]);
            return $this->redictAndforword(1,'success','添加成功',$url,[
                'controller' => $this->dispatcher->getControllerName(),
                'action' => $successAction
            ]);
        }else{
            return $obj;
        }

    }

    protected  function _update($obj,$psId,$errorAction,$successAction,$needRedict=1){
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

        if($needRedict==1) {
            return $this->redictAndforword(1, 'success', '添加成功', $url, [
                'controller' => $this->dispatcher->getControllerName(),
                'action' => $successAction
            ]);
        }
    }

    public function redictAndforword($type=1,$func='success',$message,$url='',$params=array(),$ajaxData=array(),$isReload=1){
        //如果是异步的话 直接返回
        if($this->request->isAjax()){
            if($func=='success')
                $this->createJsonReturn(1,$message,$ajaxData,$isReload);
            else
                $this->createJsonReturn(0,$message,$ajaxData,$isReload);
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


    public function createJsonReturn($code=0,$msg='',$data=array(),$isReload=1){
        echo json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$data,'isReload'=>$isReload));
        exit();
    }


    public function initialize(){
        $this->remote=$this->di['config']->source_service->remote;
        $this->remote_server=$this->di['config']->source_service->remote_server;
        $this->version=$this->di['config']->version->code;
        $this->view->setVar('remote',$this->remote);
        $this->view->setVar('remote_server',$this->remote_server);
        $this->view->setVar('version',$this->version);

        if($this->config->application->user_login_form_cookies){
            $auth=$this->_getCookie('auth');
            if (!$auth) {
                $this->view->setVar('isLogin',0);
            } else {
                $nickname = $this->_getCookie('nickname');
                $account_type = $this->_getCookie('account_type');
                $user_id= $this->_getCookie('user_id');
                $sub_account_id= $this->_getCookie('sub_account_id');

                $sysChild= $this->_getCookie('sysChild');

                $is_duty_sales= $this->_getCookie('is_duty_sales');
                $is_duty_service_staff= $this->_getCookie('is_duty_service_staff');
                $is_duty_hr= $this->_getCookie('is_duty_hr');

                $this->view->setVar('isLogin',1);
                $this->view->setVar('nickname',$nickname);
                $this->view->setVar('account_type',$account_type);
                $this->view->setVar('user_id',$user_id);
                $this->view->setVar('sysChild',$sysChild);
                $this->sysChild=$sysChild;
                $this->user_id=$user_id;
                $this->nickname=$nickname;
                $this->sub_account_id=$sub_account_id;
                $this->role_id=$account_type;

                $this->is_duty_sales=$is_duty_sales;
                $this->is_duty_service_staff=$is_duty_service_staff;
                $this->is_duty_hr=$is_duty_hr;
                $this->view->setVar('is_duty_sales',$is_duty_sales);
                $this->view->setVar('is_duty_service_staff',$is_duty_service_staff);
                $this->view->setVar('is_duty_hr',$is_duty_hr);
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
                $sysChild=$auth['sysChild'];

                $is_duty_sales= $auth['is_duty_sales'];
                $is_duty_service_staff=$auth['is_duty_service_staff'];
                $is_duty_hr=$auth['is_duty_hr'];


                $this->view->setVar('isLogin',1);
                $this->view->setVar('nickname',$nickname);
                $this->view->setVar('account_type',$account_type);
                $this->view->setVar('user_id',$user_id);
                $this->view->setVar('sysChild',$sysChild);
                $this->sysChild=$sysChild;
                $this->user_id=$user_id;
                $this->nickname=$nickname;
                $this->sub_account_id=$sub_account_id;
                $this->role_id=$account_type;

                $this->is_duty_sales=$is_duty_sales;
                $this->is_duty_service_staff=$is_duty_service_staff;
                $this->is_duty_hr=$is_duty_hr;
                $this->view->setVar('is_duty_sales',$is_duty_sales);
                $this->view->setVar('is_duty_service_staff',$is_duty_service_staff);
                $this->view->setVar('is_duty_hr',$is_duty_hr);
            }
        }

        if($this->sysChild==2){
            $this->treeSuffix='Hr';
        }
        $this->view->treeSuffix=$this->treeSuffix;
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

    public function _setCookie($key,$value,$timeout=0){
        if($timeout==0)
            $timeout =$this->config->application->cookie_remember_timeout;
        $this->cookies->set($key,$value, time()+$timeout);
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
     *multiple:多选
     *mutiUpdate:批量修改
     */
    private $default_model=array(
        'default'=>array('type'=>'text','show'=>1,'lable'=>'','ispk'=>0,'edit'=>1,'detail'=>1,'ispk'=>0,'search'=>0,'gassearch'=>0,'create'=>0,'detail'=>0,'orderby'=>0,'searchOptions'=>array(
            'qt'=>'=',
            'type'=>"and",
        ),"gsSearchOptions"=>array(
            'qt'=>['=','like'],
            'type'=>['and'],
        ),'tag'=>0,'required'=>0,'sort'=>0,'rangelength'=>null,'email'=>0,'number'=>0,'mutiUpdate'=>0,'live_search'=>0,'setEndDate'=>null,'setStartDate'=>null,"disabled"=>0,'clamp'=>0),
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
        $response->setHeader('Content-type', 'text/csv;charset=UTF-8');
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
       // $searchKey="";
        $searchKey=[];

        foreach ($_GET as $k=>$v){
            if($v!=null && isset($model[$k])){
                $mode=$model[$k];
                if($mode['search']==1 || $mode['tag']==1){
                    if($isMutiple==0){
                        //prov city 一直联动
                        if($k=='city')
                            $searchKey['province']=1;
                        else
                            $searchKey[$k]=1;
                    }
                    $condition[$k]=$mode['searchOptions'];
                    if($mode['searchOptions']['type']=='between'){
                        if(is_array($_GET[$k])){
                            $this->tag->setDefault($k,join(',',$_GET[$k]));
                            $value=join(',',$_GET[$k]);
                        }else{
                            $this->tag->setDefault($k,$_GET[$k]);
                            $value=$_GET[$k];
                        }
                        if($mode['type']=='time' || $mode['type']=='day' ){
                            $condition_list[$k]=$this->filterTimeBetween($_GET[$k]);
                        }else{
                            $condition_list[$k]=$this->filterBetween($_GET[$k]);
                        }
                    }else{
                        if($mode['type']=='time' || $mode['type']=='day' ){
                            $this->tag->setDefault($k,strtotime($_GET[$k]));
                            $condition_list[$k]=strtotime($v);
                            $value=$_GET[$k];
                        }else{
                            $this->tag->setDefault($k,$_GET[$k]);
                            $condition_list[$k]=$v;
                            $value=$_GET[$k];
                        }
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

        $this->view->setVar('searchKey',$searchKey);
        return [$condition,$condition_list];
    }

    /*
     * 构建高斯搜索
     */

    public function filterGs($model,$orderby){
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

                if($model[$key]['type']=='time'|| $model[$key]['type']=='day' ){
                    $list_value[$key]=$this->filterTimeBetween($_GET['gs-'.$key]);
                }
                else{
                    if($type=='between'){
                        $list_value[$key]=$this->filterBetween($_GET['gs-'.$key]);
                    }else{
                        $list_value[$key]=$_GET['gs-'.$key];
                    }
                }


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


    private function filterBetween($value){
        $arr=[];
        if(is_array($value)){
            $arr=$value;
        }else{
            $arr=explode(',',$value);
        }

        if(isset($arr[0])&&trim($arr[0])!=''){
            $v_1=intval($arr[0]);
        }else{
            $v_1='';
        }


        if(isset($arr[1])&&trim($arr[1])!=''){
            $v_2=intval($arr[1]);
        }else{
            $v_2='';
        }
        return [$v_1,$v_2];
    }


    /*
 *
 * 所有者信息 1 key=sub_account_id 2 key =user_id $isDutyType: 0:不区分 1：人才 2：是否是学服 3：是否是销售
 */
    public function getAccountIdList($type=1,$isDutyType=0){
        $list=array();
        $users=(new Userservice($this->di))->getAllUserByNameSort();
     //   $users= (new Userservice($this->di))->getAllUser();
        if(intval($isDutyType)==1){
            foreach ($users as $user){
                if(intval($user['is_duty_hr'])==1){
                    if($type==1)
                        $list[$user['sub_account_id']]=$user['staff_name'];
                    else{
                        $list[$user['user_id']]=$user['staff_name'];
                    }
                }

            }
        }elseif(intval($isDutyType)==2){
            foreach ($users as $user){
                if(intval($user['is_duty_service_staff'])==1){
                    if($type==1)
                        $list[$user['sub_account_id']]=$user['staff_name'];
                    else{
                        $list[$user['user_id']]=$user['staff_name'];
                    }
                }

            }
        }elseif(intval($isDutyType)==3){
            foreach ($users as $user){
                if(intval($user['is_duty_sales'])==1){
                    if($type==1)
                        $list[$user['sub_account_id']]=$user['staff_name'];
                    else{
                        $list[$user['user_id']]=$user['staff_name'];
                    }
                }
            }
        }
        else{
            foreach ($users as $user){
                if($type==1)
                    $list[$user['sub_account_id']]=$user['staff_name'];
                else{
                    $list[$user['user_id']]=$user['staff_name'];
                }
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


    protected function get_week($year,$nowYear=1) {
        $year_start = $year . "-01-01";
        $year_end = $year . "-12-31";
        $startday = strtotime($year_start);
        if (intval(date('N', $startday)) != '1') {
            $startday = strtotime("last monday", strtotime($year_start)); //获取年第一周的日期
        }
        $year_mondy = date("Y-m-d", $startday); //获取年第一周的日期

         $endday = strtotime($year_end);
        if (intval(date('N', $endday)) != '7') {
            $endday = strtotime("last sunday", strtotime($year_end));
        }

        $num = intval(date('W', $endday));
        $nowWeek=intval(date('W'));

        for ($i = 1; $i <= $num; $i++) {
            $j = $i -1;
            $start_day = date("Y-m-d", strtotime("$year_mondy $j week "));
            $end_day = date("Y-m-d", strtotime("$start_day +6 day"));

            if($nowYear==1){
                if($i<=$nowWeek){
                    $week_array[$year.'-'.sprintf("%02d",$i)] ="{$year}第{$i}周:".$start_day."~~".$end_day;
                }
            }else{
                $week_array[$year.'-'.sprintf("%02d",$i)] ="{$year}第{$i}周:".$start_day."~~".$end_day;
            }


        }
        return $week_array;
    }


    //导入文件
    /**
     * @param $file
     * @param $model
     * @param $object
     * @param int $checkPhone
     * @param null $unquieKey
     * @param int $isCbt 机考
     * @param int $isMac MAC地址
     * @param int $makeCustomerKind
     * @param array $defaultSubAccount
     * @param int $exportCm 导出到潜在用户
     * @param array $defaultExportCM 潜在用户的默认值
     * @return int $checkShare 是否要启用判断同步字段
     */
    public function _parseCvs($file,$model,$object,$checkPhone=0,$unquieKey=null,$isCbt=0,$isMac=0,$makeCustomerKind=0,$defaultSubAccount=[],$exportCm=0,$defaultExportCM=[],$checkShare=0){
        $file = fopen($file,'r');
        $i=0;
        $titles=array();
        $list=array();
        $fail_cnt=0;
        $checkUnquie=0;
        $unquieText='';
        if($unquieKey!=null){
            $unquieText=$model[$unquieKey]['lable'];
            $checkUnquie=1;
        }
        while ($data = fgetcsv($file)) { //每次读取CSV里面的一行内容
            if($i==0){
                $titles=$data;
            }else{
                $list[] = $data;
            }
            $i++;
        }
        fclose($file);
        $all_cnt=$i-1;

        if(count($titles)>0&&count($list)>0){
            $vklist=array();
            $columns=array();
            $res=1;
            foreach ($model as $k=>$v){
                $vklist[$k]=1;
            }

            foreach ($titles as $v){
                preg_match("/\([^\)]*+\)/",$v,$output);
                $_v=substr($output[0],1,-1);
                if(isset($vklist[$_v]))
                    $columns[]=$_v;
            }

            $j=0;
            $miss_list=[];
            $add_cnt=0;
            $update_cnt=0;
            $addphone_list=[];
            foreach ($list as $item) {
                $obj=new $object;
                $i=0;
                $remark=null;
                $mobile_n='';
                $data=[];
                $_origin_data=[];
                    foreach ($item as $value){
                        $value=trim(iconv('GBK', 'UTF-8', $value));
                        if($value!=null){
                            $_origin_data[$columns[$i]]=$value;
                            if($model[$columns[$i]]['type']=="select" ||$model[$columns[$i]]['type']=="radio" ){
//                                $value=trim(iconv('GBK', 'UTF-8', $value));
                                if(isset($model[$columns[$i]]['recover'])){
                                    if(isset($model[$columns[$i]]['recover'][$value])){
                                        $data[$columns[$i]]= $model[$columns[$i]]['recover'][$value];
                                    }else{
                                        $data[$columns[$i]]=reset($model[$columns[$i]]['recover']);
                                    }
                                }
                                else{
                                    $data[$columns[$i]]=$value;
                                }
                            }elseif($model[$columns[$i]]['type']=="time"||$model[$columns[$i]]['type']=="day"){
                                $time=strtotime($value);
                                if($time==false){
                                    $data[$columns[$i]]=time();
                                }else{
                                    $data[$columns[$i]]=$time;
                                }
                            }elseif($model[$columns[$i]]['type']=='number'){
                                $data[$columns[$i]]=$value;
                            }
                            elseif($columns[$i]=='phone'||$columns[$i]=='telPhone' ||$columns[$i]=='mobile_phone'){
                                $mobile_n=$value;
                                $data[$columns[$i]]=$value;
                            }
                            else{
                                $data[$columns[$i]]=$value;
                            }
                        }
                        $i++;
                    }

                if($isCbt==1){
                    $data['extraTimeStr']=$this->filterCbtExtraTimeStr($data['serialNumb']);
                }

                if($isMac==1){
                    $data['mac_md5']=md5($data['mac']);
                }

                if($makeCustomerKind>0){
                    $data['customerKind']=$makeCustomerKind;
                }

                if(!empty($defaultSubAccount)){
                    $data['sub_account_id']=$defaultSubAccount['sub_account_id'];
                    $data['user_id']=$defaultSubAccount['user_id'];
                }

                $jj= $j+2;
                if($checkPhone==1){
                    // $seed_id=$customer->getSeedId();
                    if($mobile_n!=null&&(!isset($addphone_list[$mobile_n]))){
                        //过滤下手机号码空的情况
                        //初始化到潜在用户
                        $this->_addOne($obj,$data,$miss_list,$add_cnt,$fail_cnt,$addphone_list,$mobile_n,$res,$checkUnquie,$jj,$unquieKey,$unquieText,$exportCm,$defaultExportCM,$checkShare,$_origin_data);
                    }
                }else{
                    if($mobile_n!=null)
                        $this->_addOne($obj,$data,$miss_list,$add_cnt,$fail_cnt,$addphone_list,$mobile_n,$res,$checkUnquie,$jj,$unquieKey,$unquieText,$exportCm,$defaultExportCM,$checkShare,$_origin_data);
                }
                $j++;
            }
            $data=array('all_cnt'=>$all_cnt,'add_cnt'=>$add_cnt,'update_cnt'=>$update_cnt,'list'=>$miss_list,'fail_cnt'=>$fail_cnt);
            if($res){
                return [true,$data];
            }else{
                return [false,$data];
            }
        }

    }

    /*
     * 获取时间字符串 进行转换 like AT2018103013492586290,c2018110107500065879
     */
    private function filterCbtExtraTimeStr($serialNumb){
        $result=preg_match('/[\d]+/',$serialNumb,$matchs);
        if($result==1){
            $serialNumb=$matchs[0];
            return sprintf("%d-%02d-%02d",substr($serialNumb,0,4),substr($serialNumb,4,2),substr($serialNumb,6,2));
        }else{
            return $serialNumb;
        }
    }


    private function _addOne($obj,$data,&$miss_list,&$add_cnt,&$fail_cnt,&$addphone_list,$mobile_n,&$res,$checkUnquie,$jj,$unquieKey,$unquieText,$exportCm=0,$defaultExportCM=[],$checkShare=0,$_origin_data=[]){
        try{
            $_res=$obj->save($data);
            //$_res=true;
            $res*=$_res;
            $addParams=[];
            //echo json_encode($data);
            if($_res){
                $add_cnt += 1;
                $addphone_list[$mobile_n] = 1;
                if($exportCm==1&&$mobile_n!=null){
                    $isEXport=0;
                    if($checkShare==1){
                        //需要判断是否同步
                        if(intval($data['isSharePotential'])==1){
                            $isEXport=1;
                        }
                    }else{
                        $isEXport=1;
                    }
                    if($isEXport==1){
                        //特殊处理
                        if(isset($defaultExportCM['shareIndexData'])&&!empty($defaultExportCM['shareIndexData'])){
                            foreach ($defaultExportCM['shareIndexData'] as $k=>$v){
                                $addParams[$v]=$data[$k];
                            }
                        }

                        if(isset($defaultExportCM['shareRemarkIndex'])&&!empty($defaultExportCM['shareRemarkIndex'])){
                            $addParams['remark']=$defaultExportCM['remark'].';';
                            foreach ($defaultExportCM['shareRemarkIndex'] as $k=>$v){
                                if($v=='text')
                                    $addParams['remark'].=$data[$k].",";
                                elseif($v=='select'){
                                    if(isset($_origin_data[$k])){
                                        $addParams['remark'].=$_origin_data[$k].",";
                                    }else{
                                        $addParams['remark'].=$data[$k].",";
                                    }
                                }
                            }
                        }
                        $this->exportToPotentialCustomer($mobile_n,$data[$defaultExportCM['nickNameKey']],$defaultExportCM['remark'],$defaultExportCM['customer_source'],$defaultExportCM['sub_account_id'],$defaultExportCM['user_id'],$addParams);
                    }
                }
            }
        }catch(\Exception $ex){
            $fail_cnt+=1;
            if($checkUnquie==1)
                $miss_list[]="<p>失败记录为:{$jj},{$unquieText}:{$data[$unquieKey]}</p>";
        }
    }


    public function getUcIndexByMobile($mobile){
        $url=$this->config->api->get_user_index_api;
        $params=array(
            'type'=>'mobile',
            'target'=>$mobile,
        );
        $user_id=0;
        $key=$this->config->api->signKey;
        $signClass=new Sign(1,$key);
        $data['data']=json_encode($params);
        $data['sign']=$signClass->makeSign($params);
        $result=Util::post($url,$data);
        if($result){
           $value=json_decode($result,true);
           if(isset($value['data']['mapped'])&&!empty($value['data']['mapped']))
                $user_id=$value['data']['mapped'];
        }
        return $user_id;
    }

    /**
     * 生成二维码并上传资源服务器
     * @param $content
     * @param $filename
     * @param $filePath
     * @return null
     */
    protected function makeQrCodeAndUploadSource($content,$filename,$filePath){
        $code_img=null;
        phpqrcode::png($content,$filename);
        //二维码上传资源服务器
        $_file= new \CURLFile(realpath($filename));
        $params=array(
            'filename'=>$_file
        );
        $inf='upload_pic_inf';
        $retrun=  (new Source($this->di['config']['source_service']))->uploadFile($params,$inf,0,$filePath);
        if($retrun){
            $arr= json_decode($retrun,true);
            if(intval($arr['code'])==1000){
                $code_img=$arr['data']['link']['fileUrl'];
            }
        }
        return $code_img;
    }

    /**
     * 获取客户端浏览器信息 添加win10 edge浏览器判断
     * @param  null
     * @author  Jea杨
     * @return string
     */
    function get_broswer(){
        $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
        if (stripos($sys, "Firefox/") > 0) {
            preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
            $exp[0] = "Firefox";
            $exp[1] = $b[1];  //获取火狐浏览器的版本号
        } elseif (stripos($sys, "Maxthon") > 0) {
            preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
            $exp[0] = "傲游";
            $exp[1] = $aoyou[1];
        } elseif (stripos($sys, "MSIE") > 0) {
            preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
            $exp[0] = "IE";
            $exp[1] = $ie[1];  //获取IE的版本号
        } elseif (stripos($sys, "OPR") > 0) {
            preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
            $exp[0] = "Opera";
            $exp[1] = $opera[1];
        } elseif(stripos($sys, "Edge") > 0) {
            //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
            preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
            $exp[0] = "Edge";
            $exp[1] = $Edge[1];
        } elseif (stripos($sys, "Chrome") > 0) {
            preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
            $exp[0] = "Chrome";
            $exp[1] = $google[1];  //获取google chrome的版本号
        } elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
            preg_match("/rv:([\d\.]+)/", $sys, $IE);
            $exp[0] = "IE";
            $exp[1] = $IE[1];
        }else {
            $exp[0] = "未知浏览器";
            $exp[1] = "";
        }
        return $exp;
    }


    /**
     * 检查BEANSTALKD 链接
     */
    protected function checkBeanstalkdUse($usebeanstalk){
        if ($usebeanstalk==1) {
            //check beanstalk connect
            try{
                $this->_dependencyInjector['beanstalk']->connect();
            }catch (Exception $err){
                $this->bnstalkd_Can_Conn = 0;
            }finally{
                $this->bnstalkd_Can_Conn = 1;
            }
        }
    }

    public function verifyEmail($email)
    {
        if(!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$email)){
            return false;
        }
        return true;
    }


    public function vaildEmailList($toParams){
        $flag=1;
        if(count($toParams)>0){
            foreach ($toParams as $k=>$v){
                if(!$this->verifyEmail($k)){
                    $flag=0;
                }
            }
        }else{
            $flag=0;
        }
        return $flag;
    }
    /*
     * 发送邮件
     */
    public function sendMail($title,$body,$toParams){
        //邮箱合法化验证
        if(!$this->vaildEmailList($toParams)){
            Log::email("邮箱地址不合法",[$title,$body,$toParams]);
            return false;
        }

        $this->checkBeanstalkdUse($this->config->mail->usebeanstalk);
        if($this->config->mail->usebeanstalk==1&&$this->bnstalkd_Can_Conn==1){
            $arr=array(
                'title'=>$title,
                'body'=>$body,
                'toParams'=>$toParams,
            );
            $rand_s=intval(rand(45,180));
            $result=(new BeanstalkToolkit($this->di))->putInTube("mailWorker",$arr,$rand_s);
            if($result){
                $this->di['sysLog']->log("sendMailToQueue,".json_encode([$result,$title,$toParams,$rand_s]));
            }
        }else{
            $mail_from_list=explode(',',$this->config->mail->mail_from);
            $mail_send_code=explode(',',$this->config->mail->mail_send_code);
            $cnt=count($mail_from_list);
            $value=rand(1,$cnt);
            $mail_from=$mail_from_list[$value-1];
            $mail_code=$mail_send_code[$value-1];
            $transport = (new \Swift_SmtpTransport($this->config->mail->stmp_service,$this->config->mail->stmp_port))
                ->setUsername($mail_from)
                ->setPassword($mail_code)
                ->setEncryption('ssl');

            $mailer = new \Swift_Mailer($transport);
            // Create a message
            $message = (new \Swift_Message($title))
                ->setFrom([$mail_from =>$this->config->mail->mail_from_name])
                ->setTo($toParams)
                ->setBody($body)
            ;
            // Send the message
            $result = $mailer->send($message);
            if($result){
//                Log::email("发送成功",[$title,$body,$toParams,$result]);
                return true;
            }
            else{
                //记录日志
                Log::email("发送失败",[$title,$body,$toParams,$result]);
                return false;
            }
        }
    }

    /*
     * 导入到潜在客户
     */
    public function exportToPotentialCustomer($mobilePhone,$nickname,$remark,$customer_source,$sub_account_id='admin',$user_id=1,$params=[]){
        $cmservice=new Customerservice($this->di);
        $nowTime=time();
        $allParams=array(
            'mobile_phone'=>$mobilePhone,
            'remark'=>$remark,
            'customer_name'=>$nickname,
            'customer_kind'=>1,
            'customer_source'=>$customer_source,
            'create_date'=>$nowTime,
            'update_date'=>$nowTime,
            'own_date'=>$nowTime,
            'sub_account_id'=>$sub_account_id,
            'user_id'=>$user_id,
            'remark'=>$remark
        );
        if(!empty($params))
            $allParams=array_merge($allParams,$params);

       return  $cmservice->createCustomer($allParams,1);
    }

    /*
     * 查询数据关联的KEY  通用的话关联：user_id/如果是学服的话关联：service_user_id;single_service_user_id 只显示学管是学服的数据
     */
    protected function getFilterKey($is_single_service_user=0){
        if($this->is_duty_service_staff>0){
            if($is_single_service_user==1){
                return self::SERVICE_DATA_RALATION_SINGLE_KEY;
            }
            return self::SERVICE_DATA_RALATION_KEY;
        }
        else
            return self::COMMON_DATA_RALATION_KEY;
    }

    /*
     * 获取某个客户的对应学服
     */
    public function getCustomerServiceId($customer_seed){
        $user=false;
        $customer=Customer::findFirstBySeedId($customer_seed);
        if($customer){
            $service_user_id=$customer->getServiceUserId();
            if($service_user_id>0){
                $user=$this->getUserByUserId($service_user_id);
            }
        }
        return $user;
//        if(!empty($email)){
//            $emailList=[$email];
//        }else{
//            $emailList=self::DEFALUT_XUEFU_MANAGER_EMAIL;
//        }
//        return $emailList;
    }



    public function getUserByUserId($userId){
       return  $user=User::findFirstByUserId($userId);
    }

    public function _filterOrderSubject($value){
        preg_match('/[^(]*/',$value,$matchs);
        return $matchs[0];
    }
}
