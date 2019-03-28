<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/11/16
 * Time: 14:12
 */

$targetFolder = '/files'; // Relative to the root
$foloder=$_POST['foloder'];
$remote=intval($_POST['remote']);
$type=$_POST['type'];

$verifyToken = md5('upupload123!@#' . $foloder);
//if (!empty($_FILES) && $verifyToken==$_POST['token']) {
if (!empty($_FILES) && $verifyToken==$_POST['token']) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    if(!empty($foloder)){
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder."/".$foloder;
        $filePath=$targetFolder.'/'.$foloder;
    }else{
        $filePath=$targetFolder.'/';
    }
    $is_make=0;
    if(!is_dir($targetPath)){
        if(!@mkdir($targetPath,0777,true)){
           $is_make=1;
        }
    }else{
        $is_make=1;
    }
    // Validate the file type
    $fileTypes = array('jpg','jpeg','gif','png','pdf','txt','xlsx','doc','docx'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);

    $filename=md5(date('Ymdhis').'_'.rand(1,999)).".".$fileParts['extension'];
    $targetFile = rtrim($targetPath,'/') . '/' . $filename;
    $fileUrl=rtrim($filePath,'/') . '/' . $filename;
    $code=-1;
    $msg="fail";
    $data=[];
    if (in_array($fileParts['extension'],$fileTypes)) {
        $res= move_uploaded_file($tempFile,$targetFile);
        if($res){
            $code=1;
            $msg="success";
            if($remote==1){
                //上传资源服务器
                $config=parse_ini_file('../../../app/config/config_online.ini');
                require "../../../app/common/library/Source.php";
                require "../../../app/common/library/CurlToolkit.php";
                $source=new \Zejicrm\Source($config);
                $_file= new \CURLFile(realpath($targetFile));
                $params=array(
                    'filename'=>$_file
                );
                $makeThumb=isset($_POST['makeThumb'])?intval($_POST['makeThumb']):0;
                if($type=='img'){
                    $inf='upload_pic_inf';
                }
                else{
                    $inf='upload_file_inf';
                }
                $_data=$source->uploadFile($params,$inf,0,$filePath,$makeThumb);
                if($_data){
                    $return=json_decode($_data,true);
                    if(intval($return['code'])==1000){
                        $data=$return['data']['link'];
                    }else{
                        $msg=$return['msg'];
                        $code=0;
                    }
                }else{
                    $msg="remote_server error";
                    $code=0;
                }
            }else{
                $data=array(
                    'fileName'=>$filename,
                    'ext'=>$fileParts['extension'],
                    'fileSize'=>filesize($targetFile),
                    'fileUri'=>$fileUrl,
                );
            }
        }
        echo json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$data));
    } else {
        echo json_encode(array('code'=>$code,'msg'=>'fail','data'=>[]));
    }
    exit();
}