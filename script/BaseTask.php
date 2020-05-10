<?php
/**
 * Filename: BaseTask.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-08-01 11:39
 **/
define("NO_THROW_DB", true);//保证数据库Dao不抛出异常，只是返回false
class BaseTask
{
    /**
     * Oversea_BaseTask constructor.
     *
     *
     */
    public function __construct()
    {
        $args = func_get_args();
        Bd_Log::debug("args:".json_encode($args));
        if ( is_array($args) && count($args) > 0 ) {
            $args = array_shift($args);
        }
        foreach ($args as $arg) {
            if( !is_string($arg) ) {
                continue;//
            }
            $arg = trim($arg);
            $k = strstr($arg, ':', true);
            $v = strstr($arg, ":");
            $v = ltrim($v, ":");
            $this->$k = $v;
        }
    }
    /**
     *
     */
    public function run()
    {
        Bd_Log::debug("In BaseTask run.");
        $this->init();
        $this->exec();
    }

    /**
     *
     */
    protected function init()
    {
        Bd_Log::debug("In BaseTask init.");

    }

    /**
     *
     */
    protected function exec()
    {
        Bd_Log::debug("In BaseTask exec.");
    }
    /**
     * @return int|string
     */
    protected function getIp()
    {
        $hostname = $_SERVER['HOSTNAME'];//低版本不支持
        if(!$hostname) {
            return "";
        }
        $ip = gethostbyname($hostname);
        $long = ip2long($ip);
        if (false === $long || -1 == $long) {
            return "";
        }
        return $long; //例如 170822439
    }

    /**
     * @return string
     */
    protected function  getTaskId()
    {
        $ip = ip2long($this->getIp());
        return  $ip . posix_getpid();//
    }



}