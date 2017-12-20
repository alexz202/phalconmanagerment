<?php
/**
 * Created by PhpStorm.
 * User: alexzhu
 * Date: 14-8-15
 * Time: 下午6:39
 */
//use Phalcon\Logger\Adapter;
//use Phalcon\Logger\AdapterInterface;
namespace Zejicrm;

use Zejicrm\Modules\Frontend\Models\Userlog;

class Userlogger
{

    protected $_dependencyInjector;
    protected $_usebeanstalk;

    public function __construct($dependencyInjector, $usebeanstalk=false)
    {
        $this->_dependencyInjector = $dependencyInjector;
        $this->_usebeanstalk = $usebeanstalk;
    }

    /**
     * @param $type
     * @param $message
     * @param array $context
     * action
     */
    public function log($actionType,$message,$context = null)
    {
        $logger = new Userlog();
        $logger->setUserId($context['user_id']);
        $logger->setUserName($context['user_name']);
        $logger->setCreatetime(time());
        $logger->setAction($actionType);
        $logger->setRemark(isset($message)?$message:'');


        if (!$logger->save()) {
            $message = ' add user log error: |' . join('|', $context);
            $logger = new \Phalcon\Logger\Adapter\File("../app/logs/error.log");
            $logger->log($message);
            return false;
        } else
            return true;
    }

//    public function setFormatter($formatter = '')
//    {
//    }

    public function setLogLevel($leve = 0)
    {
    }

    public function getLogLevel()
    {
    }

    public function begin()
    {
    }

    public function commit()
    {
    }

    public function rollback()
    {
    }

    public function close()
    {
    }

    public function debug($message, array $context = NULL)
    {
    }

    public function info($message, array $context = NULL)
    {
    }

    public function notice($message, array $context = NULL)
    {
    }

    public function warning($message, array $context = NULL)
    {
    }

    public function error($message, array $context = NULL)
    {
    }

    public function critical($message, array $context = NULL)
    {
    }

    public function alert($message, array $context = NULL)
    {
    }

    public function emergency($message, array $context = NULL)
    {
    }

    public function logInternal($message, $type, $time, $context)
    {
    }

    public function getFormatter()
    {
    }
}