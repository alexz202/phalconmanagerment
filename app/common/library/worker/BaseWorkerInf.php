<?php
/**
 * Created by PhpStorm.
 * User: alexzhu
 * Date: 2018/12/25
 * Time: 6:09 PM
 */
namespace Zejicrm\worker;

 interface BaseWorkerInf{
     public function addWorker($config,$di,$job);
}