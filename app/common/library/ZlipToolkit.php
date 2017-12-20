<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/4/24
 * Time: 9:07
 */
namespace Zejicrm;

class ZlipToolkit{
        private static $currentdir=BASE_PATH."/files/";
        public static function toZip($items,$makeZipFile='course'){
            $zip= new \ZipArchive;
            $zipname=md5($makeZipFile).'.zip';
            $zipath=self::$currentdir.$zipname;
            if(!file_exists($zipath)){
                if($zip->open($zipath,$zip::OVERWRITE|$zip::CREATE)==true){
                    foreach ($items as $item) {
                        if(is_dir($item['fullpath']))
                            $zip->addEmptyDir($item['fullpath']);
                        elseif(is_file($item['fullpath']))
                            $zip->addfile($item['fullpath'],$item['filename']);
                    }
                    $zip->close();
                }else{
                        die('zip err');
                }
            }
            return array('filename'=>$zipname,'fullpath'=>$zipath,'ext'=>'zip');
        }

        public static function download($filePath,$filename){
            if (file_exists($filePath)){
                //打开文件
                $file = fopen($filePath,"r");
                //返回的文件类型
                Header("Content-type: application/octet-stream");
                //按照字节大小返回
                Header("Accept-Ranges: bytes");
                //返回文件的大小
                 Header("Accept-Length: ".filesize($filePath));
                 //这里对客户端的弹出对话框，对应的文件名
                Header("Content-Disposition: attachment; filename=".$filename);
                //修改之前，一次性将数据传输给客户端
               echo fread($file, filesize($filePath));
                //修改之后，一次只传输1024个字节的数据给客户端
                //向客户端回送数据
                $buffer=1024;//
                //判断文件是否读完
                while (!feof($file)) {
                    //将文件读入内存
                    $file_data=fread($file,$buffer);
                     //每次向客户端回送1024个字节的数据
                    echo $file_data;
               }
                fclose($file);
            }else {
                    return false;
            }
        }
}