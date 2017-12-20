<?php
namespace Zejicrm\Modules\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\FileEx;
use Zejicrm\Modules\Frontend\Models\ColumnsIndex;
use Zejicrm\Modules\Frontend\Services\ColumnsIndexservice;
use Zejicrm\Mylog;

class ColumnsController extends ControllerBase
{
    public $model=array(
        'id'=>array('type'=>'text','lable'=>'ID','show'=>0,'ispk'=>1,'edit'=>0),
        'key'=>array('type'=>'text','lable'=>'键名','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1),
        'ispk'=>array('type'=>'radio','lable'=>'是否主键','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )
            ),
        'lable'=>array('type'=>'text','lable'=>'标题','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
                'options'=>array(
                    "0"=>array("text"=>"否","selected"=>1),
                    "1"=>array("text"=>"是","selected"=>0),
                )
            ),
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
        'search'=>array('type'=>'radio','lable'=>'搜索','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
                'options'=>array(
                    "0"=>array("text"=>"否","selected"=>1),
                    "1"=>array("text"=>"是","selected"=>0),
                )
            ),
        'gassearch'=>array('type'=>'radio','lable'=>'高级搜索','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
          'options'=>array(
                    "0"=>array("text"=>"否","selected"=>1),
                    "1"=>array("text"=>"是","selected"=>0),
                )
        ),
        'orderby'=>array('type'=>'radio','lable'=>'排序项','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )
            ),
        'tag'=>array('type'=>'radio','radio'=>'开启标签','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
            'options'=>array(
                "0"=>array("text"=>"否","selected"=>1),
                "1"=>array("text"=>"是","selected"=>0),
            )
            ),
        'required'=>array('type'=>'radio','lable'=>'是否必要','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,
            'options'=>array(
            "0"=>array("text"=>"否","selected"=>1),
            "1"=>array("text"=>"是","selected"=>0),
            )
        ),
        'sort'=>array('type'=>'text','lable'=>'排序','show'=>1,'edit'=>0,'ispk'=>0,'create'=>0,'search'=>0,'gassearch'=>0,'detail'=>0),
        'searchOptions'=>array('type'=>'text','lable'=>'搜索条件','show'=>0,'edit'=>0,'ispk'=>0,'create'=>0,'search'=>0,'gassearch'=>0,'detail'=>0),
        'gssearchOptions'=>array('type'=>'text','lable'=>'高级搜索条件','show'=>0,'edit'=>0,'ispk'=>0,'create'=>0,'search'=>0,'gassearch'=>0,'detail'=>0),
        'controller'=>array('type'=>'select','lable'=>'控制器','show'=>1,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>1,'gassearch'=>0,'detail'=>1,
        'options'=>array(
                'customer'=>array("text"=>"客户管理","selected"=>1),
                'customerfollow'=>array("text"=>"客户跟进","selected"=>0),
                'order'=>array("text"=>"订单管理","selected"=>0),
            )),
        'action'=>array('type'=>'text','lable'=>'行为','show'=>0,'edit'=>0,'ispk'=>0,'create'=>0,'search'=>0,'gassearch'=>0,'detail'=>1,
            ),
        'type'=>array('type'=>'select','lable'=>'类型','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,),
        'extra'=>array('type'=>'text','lable'=>'扩展','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,),
         'width'=>array('type'=>'text','lable'=>'宽带','show'=>0,'edit'=>1,'ispk'=>0,'create'=>1,'search'=>0,'gassearch'=>0,'detail'=>1,)
    );



    private function settingColumnsIndexToModel(){
//        $this->init(new CustomerController(),'Customer');
//        sleep(2);
//        $this->init(new CustomerfollowController(),'Customerfollow');
//        sleep(2);
//        $this->init(new OrderController(),'Order');
        $this->model['type']['options']=$this->setSelectOptions($this->getDictByStatic('columnsType'));
    }



    public function sortListAction(){
        $model=$this->defaultSettingModel($this->model);
        $controller=$this->request->get('controller');
        if(isset($controller)){
            $selfCondition['condition']=array('controller'=>array());
            $selfCondition['condition']=array('controller'=>array(),'show'=>array());
            $selfCondition['condition_list']=array('controller'=>$controller,'show'=>1);
            $this->_index($model,'ColumnsIndex','Zejicrm\Modules\Frontend\Models\ColumnsIndex',$selfCondition,'sort desc');
            $this->view->setVar('chooseController',1);
        }else{
            $this->view->models=$model;
            $this->view->setVar('chooseController',0);
        }
    }

    public function makeAction(){
        $fileEx=new FileEx($this->di,'columns.json');
        $list=array();


        $columns= ColumnsIndex::find();
        $columns=$columns->toArray();


//        $controller->model
        $type_index= $this->getDictByStatic('columnsType')->toArray();
        foreach ($columns as $v){
            $controller=$v['controller'];
            if(!empty($v['searchOptions'])){
                $v['searchOptions']=json_decode($v['searchOptions']);
            }else{
                unset($v['searchOptions']);
            }


            if(!empty($v['gssearchOptions'])){
                $v['gsSearchOptions']=json_decode($v['gssearchOptions']);
            }
            if(empty($v['class'])){
                unset($v['class']);
            }

            if(empty($v['width'])){
                unset($v['width']);
            }


            if(!empty($v['extra'])){
                $arr=json_decode($v['extra'],true);
                $v=array_merge($v,$arr);
            }

            unset($v['gssearchOptions']);
            unset($v['controller']);
            unset($v['action']);
            unset($v['id']);
            unset($v['extra']);

            $v['type']=$type_index[$v['type']];
            $list[$controller][$v['key']]=$v;
        }
        $fileEx->makeFile($list);
        return  $this->response->redirect('/columns/index');
    }



    public function submitSortAction(){
        if($this->request->isAjax()){
            $id= $this->request->getPost('id');
            $type= $this->request->getPost('type');

//            $id=2;
//            $type=2;
            $o_obj=ColumnsIndex::findFirstById($id);
            $controller=$o_obj->getController();
            $sort=$o_obj->getSort();
            $o_sort_v=$o_obj->getSort();
            $p_obj=(new ColumnsIndexservice($this->di))->getNearId($controller,$sort,$type);
            if($p_obj){
                $p_obj=$p_obj[0];
                if($type==2 &&intval($p_obj->getSort())==0){
                    //往下为0的话 不处理 先设定值
                    $this->redictAndforword(1,'error','error');
                }
              //  $pid=$p_obj->getId();
                $o_obj->setSort(intval($p_obj->getSort()));
                $o_obj->save();

//                $_p_obj=ColumnsIndex::findFirstById($pid);
                $p_obj->setSort(intval($o_sort_v));
                $p_obj->save();
                $this->redictAndforword(1,'success','success');
            }else{
                $this->redictAndforword(1,'error','error');
            }
        }
    }


    private function init($controller,$controllerName){
      //  $controller =new CustomerController();

//        $controller->model
       $type_index= array_flip($this->getDictByStatic('columnsType')->toArray());

        $model=$this->defaultSettingModel($controller->model);
        foreach ($model as $key=>$v){
            $ColumnsIndex=new ColumnsIndex();
            $ColumnsIndex->setIspk(intval($v['ispk']));
            $ColumnsIndex->setKey($key);
            $ColumnsIndex->setShow(intval($v['show']));
            $ColumnsIndex->setCreate(intval($v['create']));
            $ColumnsIndex->setEdit(intval($v['edit']));
            $ColumnsIndex->setDetail(intval($v['detail']));
            $ColumnsIndex->setSearch(intval($v['search']));
            $ColumnsIndex->setGassearch(intval($v['gassearch']));
            $ColumnsIndex->setLable($v['lable']);
            $ColumnsIndex->setOrderby(intval($v['orderby']));
            $ColumnsIndex->setRequired(intval($v['required']));
            $ColumnsIndex->setController($controllerName);
            $ColumnsIndex->setTag(intval($v['tag']));
            $ColumnsIndex->setType(intval($type_index[$v['type']]));
            $ColumnsIndex->setSort(intval($v['sort']));
            $ColumnsIndex->setSearchoptions(json_encode($v['searchOptions']));
            $ColumnsIndex->setGssearchoptions(json_encode($v['gsSearchOptions']));
            if(isset($v['width']))
                $ColumnsIndex->setWidth($v['width']);
            if(isset($v['class']))
                $ColumnsIndex->setClass($v['class']);

           $res= $ColumnsIndex->save();
//            foreach ($ColumnsIndex->getMessages() as $message) {
//                $this->flash->error($message);
//            }
//           var_dump($res);
        }

    }

    public function initialize()
    {
        $this->view->setVar('treeId',4);
        $this->settingColumnsIndexToModel();
        parent::initialize();
    }


    /**
     * index for ColumnsIndex
     */
    public function indexAction()
    {
        $model=$this->defaultSettingModel($this->model);
        $this->_index($model,'ColumnsIndex','Zejicrm\Modules\Frontend\Models\ColumnsIndex',array(),'sort desc');
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
     * Edits a ColumnsIndex
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $ColumnsIndex = ColumnsIndex::findFirstByid($id);
            if (!$ColumnsIndex) {
                $this->flash->error("ColumnsIndex was not found");

                $this->dispatcher->forward([
                    'controller' => "ColumnsIndex",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $ColumnsIndex->getId();

            $this->tag->setDefault("id", $ColumnsIndex->getId());
            $this->tag->setDefault("key", $ColumnsIndex->getKey());
            $this->tag->setDefault("type", $ColumnsIndex->getType());
            $this->tag->setDefault("ispk", $ColumnsIndex->getIspk());
            $this->tag->setDefault("lable", $ColumnsIndex->getLable());
            $this->tag->setDefault("show", $ColumnsIndex->getShow());
            $this->tag->setDefault("create", $ColumnsIndex->getCreate());
            $this->tag->setDefault("edit", $ColumnsIndex->getEdit());
            $this->tag->setDefault("detail", $ColumnsIndex->getDetail());
            $this->tag->setDefault("search", $ColumnsIndex->getSearch());
            $this->tag->setDefault("gassearch", $ColumnsIndex->getGassearch());
            $this->tag->setDefault("orderby", $ColumnsIndex->getOrderby());
            $this->tag->setDefault("tag", $ColumnsIndex->getTag());
            $this->tag->setDefault("required", $ColumnsIndex->getRequired());
           // $this->tag->setDefault("sort", $ColumnsIndex->getSort());
            $this->tag->setDefault("searchOptions", $ColumnsIndex->getSearchoptions());
            $this->tag->setDefault("gssearchOptions", $ColumnsIndex->getGssearchoptions());
            $this->tag->setDefault("controller", $ColumnsIndex->getController());
            $this->tag->setDefault("action", $ColumnsIndex->getAction());
            $this->tag->setDefault("extra", $ColumnsIndex->getExtra());
            $this->tag->setDefault("width", $ColumnsIndex->getWidth());

            $sqt='';
            $stype='';
            $gsqt='';
            $gstype='';


            if( intval($ColumnsIndex->getSearch())==1){

                if($ColumnsIndex->getSearchoptions()!=null){
                    $qttype=json_decode($ColumnsIndex->getSearchoptions(),true);
                    $sqt=$qttype['qt'];
                    $stype=$qttype['type'];
                }

            }


            if( intval($ColumnsIndex->getGassearch())==1){

                if($ColumnsIndex->getGssearchoptions()!=null){
                    $qttype=json_decode($ColumnsIndex->getGssearchoptions(),true);
                    $gsqt=implode(',',$qttype['qt']);
                    $gstype=$qttype['type'][0];
                }


            }

            $this->view->setVar('sqt',$sqt);
            $this->view->setVar('stype',$stype);
            $this->view->setVar('gsqt',$gsqt);
            $this->view->setVar('gstype',$gstype);


            $model=$this->defaultSettingModel($this->model);
            $this->view->models=$model;

            //设置门板打开方式
            $this->settingLayer();
            
        }
    }

    /**
     * Creates a new ColumnsIndex
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "ColumnsIndex",
                'action' => 'index'
            ]);

            return;
        }

        $ColumnsIndex = new ColumnsIndex();

       // $ColumnsIndex->setId($this->request->getPost("id"));
        $ColumnsIndex->setKey($this->request->getPost("key"));
        $ColumnsIndex->setType($this->request->getPost("type"));
        $ColumnsIndex->setIspk($this->request->getPost("ispk"));
        $ColumnsIndex->setLable($this->request->getPost("lable"));
        $ColumnsIndex->setShow($this->request->getPost("show"));
        $ColumnsIndex->setCreate($this->request->getPost("create"));
        $ColumnsIndex->setEdit($this->request->getPost("edit"));
        $ColumnsIndex->setDetail($this->request->getPost("detail"));
        $ColumnsIndex->setSearch($this->request->getPost("search"));
        $ColumnsIndex->setGassearch($this->request->getPost("gassearch"));
        $ColumnsIndex->setOrderby($this->request->getPost("orderby"));
        $ColumnsIndex->setTag($this->request->getPost("tag"));
        $ColumnsIndex->setRequired($this->request->getPost("required"));
        $ColumnsIndex->setSort($this->request->getPost("sort"));
      //  $ColumnsIndex->setSearchoptions($this->request->getPost("searchOptions"));
       // $ColumnsIndex->setGssearchoptions($this->request->getPost("gssearchOptions"));
        $ColumnsIndex->setController($this->request->getPost("controller"));
        $ColumnsIndex->setAction($this->request->getPost("action"));
        $ColumnsIndex->setExtra($this->request->getPost("extra"));
        $ColumnsIndex->setWidth($this->request->getPost("width"));

        if($this->request->getPost("search")==1){

            $searchOptions=array(
                'qt'=>$this->request->getPost("sqt"),
                'type'=>$this->request->getPost("stype"),
            );

            $ColumnsIndex->setSearchoptions(json_encode($searchOptions));
        }
        if($this->request->getPost("gassearch")==1){
            $gsearchOptions=array(
                'qt'=>[$this->request->getPost("gsqt")],
                'type'=>[$this->request->getPost("gstype")],
            );
            $ColumnsIndex->setGssearchoptions(json_encode($gsearchOptions));
        }



        if (!$ColumnsIndex->save()) {
            foreach ($ColumnsIndex->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ColumnsIndex",
                'action' => 'new'
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
        return $this->redictAndforword(1,'success','创建成功','/Columns/index',[
            'controller' => "customer",
            'action' => 'public'
        ]);


    }

    /**
     * Saves a ColumnsIndex edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "ColumnsIndex",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $ColumnsIndex = ColumnsIndex::findFirstByid($id);

        if (!$ColumnsIndex) {
            $this->flash->error("ColumnsIndex does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "ColumnsIndex",
                'action' => 'index'
            ]);

            return;
        }

      //  $ColumnsIndex->setId($this->request->getPost("id"));
        $ColumnsIndex->setKey($this->request->getPost("key"));
        $ColumnsIndex->setType($this->request->getPost("type"));
        $ColumnsIndex->setIspk($this->request->getPost("ispk"));
        $ColumnsIndex->setLable($this->request->getPost("lable"));
        $ColumnsIndex->setShow($this->request->getPost("show"));
        $ColumnsIndex->setCreate($this->request->getPost("create"));
        $ColumnsIndex->setEdit($this->request->getPost("edit"));
        $ColumnsIndex->setDetail($this->request->getPost("detail"));
        $ColumnsIndex->setSearch($this->request->getPost("search"));
        $ColumnsIndex->setGassearch($this->request->getPost("gassearch"));
        $ColumnsIndex->setOrderby($this->request->getPost("orderby"));
        $ColumnsIndex->setTag($this->request->getPost("tag"));
        $ColumnsIndex->setRequired($this->request->getPost("required"));
       // $ColumnsIndex->setSort($this->request->getPost("sort"));
      //  $ColumnsIndex->setSearchoptions($this->request->getPost("searchOptions"));
        //$ColumnsIndex->setGssearchoptions($this->request->getPost("gssearchOptions"));
        $ColumnsIndex->setController($this->request->getPost("controller"));
        $ColumnsIndex->setAction($this->request->getPost("action"));
        $ColumnsIndex->setExtra($this->request->getPost("extra"));
        $ColumnsIndex->setWidth($this->request->getPost("width"));

        if($this->request->getPost("search")==1){
            $searchOptions=array(
                'qt'=>$this->request->getPost("sqt"),
                'type'=>$this->request->getPost("stype"),
            );

            $ColumnsIndex->setSearchoptions(json_encode($searchOptions));
        }
        if($this->request->getPost("gassearch")==1){
            $gsearchOptions=array(
                'qt'=>[$this->request->getPost("gsqt")],
                'type'=>[$this->request->getPost("gstype")],
            );
            $ColumnsIndex->setGssearchoptions(json_encode($gsearchOptions));
        }


        if (!$ColumnsIndex->save()) {

            foreach ($ColumnsIndex->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ColumnsIndex",
                'action' => 'edit',
                'params' => [$ColumnsIndex->getId()]
            ]);

            return;
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'save',
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_POST
            ));

        return $this->redictAndforword(1,'success','保存成功','/Columns/index',[
            'controller' => "Columns",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a ColumnsIndex
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $ColumnsIndex = ColumnsIndex::findFirstByid($id);
        if (!$ColumnsIndex) {
            $this->flash->error("ColumnsIndex was not found");

            $this->dispatcher->forward([
                'controller' => "ColumnsIndex",
                'action' => 'index'
            ]);

            return;
        }

        if (!$ColumnsIndex->delete()) {

            foreach ($ColumnsIndex->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ColumnsIndex",
                'action' => 'search'
            ]);

            return;
        }

        (new Mylog($this->di))->log($this->dispatcher->getActionName(),'delete:'.$id,
            array(
                'controll'=>$this->dispatcher->getControllerName(),
                'userId'=>$this->user_id,
                'username'=>$this->nickname,
                "data"=>$_GET
            ));

        return $this->redictAndforword(1,'success','删除成功','/Columns/index',[
            'controller' => "Columns",
            'action' => 'index'
        ]);
    }

    public function makeColumnsIndexAction(){
            $fileEx=new FileEx($this->di,'ColumnsIndex.json');
            $list=array();

            $ColumnsIndexType= $this->getColumnsIndexByStatic('ColumnsIndexType');

            $ColumnsIndexAll=ColumnsIndex::find();
             $ColumnsIndexAll=$ColumnsIndexAll->toArray();
             foreach ($ColumnsIndexAll as $ColumnsIndex){
                 $list[$ColumnsIndex['type']][$ColumnsIndex['key']]=$ColumnsIndex['value'];
             }
            $fileEx->makeFile($list);
            return  $this->response->redirect('/ColumnsIndex/index');
    }

}
