<?php
/**
 * Created by PhpStorm.
 * User: zjy202
 * Date: 2017/8/4
 * Time: 14:54
 */
namespace Zejicrm;

use Phalcon\Cache\Backend as Base;
use Phalcon\Cache\Exception;

class RedisEx extends Base
{
    public function __construct($frontend, $options)
    {
        if (!isset($options['redis'])) {
            throw new Exception("Parameter 'redis' is required");
        }
        parent::__construct($frontend, $options);

    }

    public function save($keyName = NULL, $content = NULL, $lifetime = NULL, $stopBuffer = NULL){

    }
    public function delete($keyName){

    }
    public function queryKeys($prefix = NULL){

    }
    public function flush(){

    }

    /*
     * set key
     */

    public function set($key, $value,$lifetime=null)
    {
        $Options = $this->getOptions();
        if(!empty($lifetime)){
            return $Options['redis']->set($key, $value,$lifetime);
        }
        else
            return $Options['redis']->set($key, $value);
    }

    /*
     * get key
     */
    public function get($key,$lifetime=null)
    {
        $Options = $this->getOptions();
        return $Options['redis']->get($key);
    }

    /*
     * exists
     */
    public function exists($keyName = NULL, $lifetime = NULL)
    {
        $Options = $this->getOptions();
        return $Options['redis']->exists($keyName);
    }

    /*
     * del key
     */
    public function del($key)
    {
        $Options = $this->getOptions();
        return $Options['redis']->del($key);
    }

    /*
     * hset
     */
    public function hset($object, $field, $value)
    {
        $Options = $this->getOptions();
        return $Options['redis']->hset($object, $field, $value);
    }

    /*
     * hget
     */
    public function hget($object, $field)
    {
        $Options = $this->getOptions();
        return $Options['redis']->hset($object, $field);
    }

    /*
     *
     * hgetall
     *
     */
    public function hgetall($object)
    {
        $Options = $this->getOptions();
        return $Options['redis']->hgetall($object);
    }

    /* hExists
     *
     */
    public function hExists($object, $field)
    {
        $Options = $this->getOptions();
        return $Options['redis']->hExists($object, $field);
    }

    /*
     * hdel
     */
    public function hDel($object, $field)
    {
        $Options = $this->getOptions();
        return $Options['redis']->hDel($object, $field);
    }

    /*
     * increment value
     */
    public function hIncrBy($object, $field, $value)
    {
        $Options = $this->getOptions();
        return $Options['redis']->hIncrBy($object, $field, $value);
    }

    /*
     * sAdd
     */
    public function sAdd($key, $value)
    {
        $Options = $this->getOptions();
        return $Options['redis']->sAdd($key, $value);
    }

    /*
     * sSize
     */
    public function sSize($key)
    {
        $Options = $this->getOptions();
        return $Options['redis']->sSize($key);
    }

    /*
     * sIsMember
     */
    public function sIsMember($key, $value)
    {
        $Options = $this->getOptions();
        return $Options['redis']->sIsMember($key, $value);
    }
    /****sort list *****/
    public function zadd($key,$score,$member){
        $Options = $this->getOptions();
        return $Options['redis']->zadd($key,$score,$member);
    }

    public function zrange($key,$start,$end,$type=true){
        $Options = $this->getOptions();
        if($type===false)
            return $Options['redis']->zrange($key,$start,$end);
        else
            return $Options['redis']->zrange($key,$start,$end,'withscores');
    }


    public function zrevrange($key,$start,$end,$type=true){
        $Options = $this->getOptions();
        if($type===false)
            return $Options['redis']->zrevrange($key,$start,$end);
        else
            return $Options['redis']->zrevrange($key,$start,$end,'withscores');
    }

    public function zrank($key,$member){
        $Options = $this->getOptions();
        return $Options['redis']->zrank($key,$member);
    }

    public function zrevrank($key,$member){
        $Options = $this->getOptions();
        return $Options['redis']->zrevrank($key,$member);
    }

    public function zscore($key,$member){
        $Options = $this->getOptions();
        return $Options['redis']->zscore($key,$member);
    }

    public function zrem($key,$member){
        $Options = $this->getOptions();
        return $Options['redis']->zscore($key,$member);
    }
    public function zcount($key,$min,$max){
        $Options = $this->getOptions();
        return $Options['redis']->zcount($key,$min,$max);
    }
    public function zrevrangebyscore($key,$max,$min,$type=true)
    {
        $Options = $this->getOptions();
        if($type===false)
            return $Options['redis']->zrevrangebyscore($key,$max,$min);
        else
            return $Options['redis']->zrevrangebyscore($key,$max,$min,'withscores');
    }


}