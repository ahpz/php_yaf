<?php
/**
 * Filename: Base.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-06-25 18:12
 **/
abstract class Service_Data_Base
{
    protected $cluster = null;
    protected $objDb  = null;

    private static $instances = array();
    /**
     * @return mixed
     */
    public static function getInstance()
    {

        $classname = get_called_class();
        //self 当前函数所在类 static 当前调用的类名Service_Data_Admin:: 要求php5.3+ 支持 static
        if (! isset(self::$instances[$classname])) {
            self::$instances[$classname] = new static();
        }

        return self::$instances[$classname];
    }


    /**
     * 派生类重写构造函数 初始化 tbName
     */
    protected function __construct()
    {
        $this->cluster = 'cluster_kuajing';
        $this->objDb  = new Dao_Base($this->cluster);
        $this->init();
    }

    protected function init()
    {
        Bd_Log::debug("in method ".__METHOD__);
    }

    /**
     *
     */
    protected  function logSql()
    {
        Bd_Log::debug("errno:".$this->getLastErrNo().":errno:|".$this->getLastErrMsg().":error | ".$this->objDb->getLastSql().":sql");
    }

    /**
     * 返回错误码
     * @return mixed
     */
    public function getLastErrNo()
    {
        return $this->objDb->errno();
    }

    /**
     * 返回错误信息
     * @return mixed
     */
    public function  getLastErrMsg()
    {
        return $this->objDb->error();
    }
}