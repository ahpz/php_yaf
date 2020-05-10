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
 * CreateDate:2017-06-25 18:09
 **/
class Dao_Base
{
    protected $objDb = null;

    /**
     * Oversea_Dao_Base constructor.
     * @param $cluster
     */
    public function __construct($cluster)
    {
        Bd_Log::debug(__METHOD__." | cluster:{$cluster}");
        $this->objDb  = Bd_Db_ConnMgr::getConn($cluster);
    }


    /**
     * dao 层默认的统一入口 优点：方便记录日志 控制异常返回 还是直接返回 false
     * @param $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments = array())
    {
        // TODO: Implement __call() method.
        Bd_Log::debug("method:{$method} | args:".var_export($arguments, true));
        $mixRet = call_user_func_array(array($this->objDb, $method), $arguments);
        Bd_Log::debug($this->objDb->getLastSql().":sql");
        Bd_Log::debug("mixRet:".json_encode($mixRet));
        if (false === $mixRet) {
            //调试bug
            Bd_Log::warning($this->objDb->getLastSql().":sql");
            Bd_Log::warning($this->objDb->errno().":errno | ".$this->objDb->error().":error");
            if (!defined("NO_THROW_DB")) {
                throw new Exception("数据库异常!");
            }
        }
        return $mixRet;


    }


}