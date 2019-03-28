<?php
/**
 * Created by PhpStorm.
 * User: alexzhu
 * Date: 2018/12/26
 * Time: 11:24 AM
 */
namespace Zejicrm\worker;
use Zejicrm\BeanstalkToolkit;
use Zejicrm\Log;

class MailWorker implements \Zejicrm\worker\BaseWorkerInf{

    public function addWorker($config,$di,$job){
        $str= $job->getBody();
        $jobId=$job->getId();
        $content=json_decode($str,true);
        $title=$content['title'];
        $body=$content['body'];
        $toParams=$content['toParams'];
        $tube=$content['tube'];
        $createTs=$content['createTs'];
        $mail_from_list=explode(',',$config->mail->mail_from);
        $mail_send_code=explode(',',$config->mail->mail_send_code);
        $cnt=count($mail_from_list);
        $value=rand(1,$cnt);
        $mail_from=$mail_from_list[$value-1];
        $mail_code=$mail_send_code[$value-1];
        $transport = (new \Swift_SmtpTransport($config->mail->stmp_service,$config->mail->stmp_port))
            ->setUsername($mail_from)
            ->setPassword($mail_code)
            ->setEncryption('ssl');
        $mailer = new \Swift_Mailer($transport);
        // Create a message
        $message = (new \Swift_Message($title))
            ->setFrom([$mail_from =>$config->mail->mail_from_name])
            ->setTo($toParams)
            ->setBody($body)
        ;
        // Send the message
        $result = $mailer->send($message);
        Log::email("异步发送邮件",[$title,$body,$toParams,$result,$cnt]);
        if($result){
            //成功删除REDIS记录
            $beanstalkToolkit =new BeanstalkToolkit($di);
            $beanstalkToolkit->deleteForRedis($tube,$jobId,$createTs);
        }else{
            Log::email("发送失败",[$title,$body,$toParams,$result]);
        }
        return true;
    }
}