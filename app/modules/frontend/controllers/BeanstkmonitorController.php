<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2019/3/18
 * Time: 14:14
 */
namespace Zejicrm\Modules\Frontend\Controllers;

use duncan3dc\Forker\Exception;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Zejicrm\Mylog;
use Phalcon\Queue\Beanstalk\Extended as BeanstalkExtended;
use Phalcon\Queue\Beanstalk\Job;

class BeanstkmonitorController extends ControllerBase{


    public function initialize()
    {
        $this->view->setVar('treeId',5);
        $this->view->nodeName='beanstkmonitor';
        parent::initialize();
    }

    public function indexAction(){
       $tubesList= $this->di['beanstalk']->getTubes();
       $list=[];
       foreach ($tubesList as $tube){
            if($tube!='default'){
                $list[$tube]=$this->di['beanstalk']->getTubeStats($tube);
            }
       }
       $this->view->setVar('list',$list);
//
//        $status=$this->di['beanstalk']->getTubeStats('mailWorker');
//        var_dump($status);
//        $count=$status['current-jobs-ready'];
        //$this->di['beanstalk']->choose('mailWorker');
//        $list=$this->di['beanstalk']->reserveFromTube('mailWorker');
//        var_dump($list);

       // $this->getOne($this->di['beanstalk']);
    }

    public function showTubeAction($tube){
        if(!isset($tube)){
            die('error tube');
        }
        try{
            $tubeInfo=$this->di['beanstalk']->getTubeStats($tube);
        }catch (Exception $ex){
            die($ex);
        }
        $list=[];
        if(isset($tubeInfo)){
            $cnt=intval($tubeInfo['current-jobs-ready']);
            if($cnt>0){
                for ($i=0;$i<$cnt;$i++){
                    $_job=$this->di['beanstalk']->reserveFromTube($tube);
                    $body=json_decode($_job->getBody(),true);
                    $createTs=date('Y-m-d H:i:s',$body['createTs']);
                    unset($body['createTs']);
                    unset($body['tube']);

                    $list[]=array(
                        'jobId'=>$_job->getId(),
                        'body'=>var_export($body,true),
                        'createTs'=>$createTs,
                    );
                }
            }
        }
        $this->view->setVar('list',$list);
    }

    public function operateAction($type=1){
        if($this->request->isAjax()){
            if($type==1){
                //删除Job
                $jobId=$this->request->getPost('param1');
                if(intval($jobId)>0){
                    $job=$this->di['beanstalk']->jobPeek($jobId);
                    $result= $job->delete();
                    if($result){
                        $this->createJsonReturn(1,'success');
                    }
                }
                $this->createJsonReturn(0,'fail');
            }elseif($type==2){
                //kick
                $tube=$this->request->getPost('param1');
                $this->di['beanstalk']->choose($tube);
                $tubeInfo=$this->di['beanstalk']->getTubeStats($tube);
                $cnt=intval($tubeInfo['total-jobs']);
                if($cnt>0){
                    $result= $this->di['beanstalk']->kick($cnt);
                    if($result){
                        $this->createJsonReturn(1,'success');
                    }
                }
                $this->createJsonReturn(0,'fail');
            }
            else{
                $this->createJsonReturn(0,'fail');
            }
        }
        $this->createJsonReturn(0,'fail');
    }
}
