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
 * CreateDate:2017-06-25 18:13
 **/
abstract class Service_Page_Base
{
    //优化扩充 方法
    //102 0000 - 102 1111 权限管理系统 自定义错误 区间

    protected $arrInput = array();
    protected $arrOutput= array();

    /**
     * Service_Page_Base constructor.
     * * @param $arrInput
     *
     */
    public function __construct($arrInput)
    {
        $this->arrInput = $arrInput;
        $this->arrOutput = array(
            'ret' => 0,
            'msg' => 'OK',
            'content' => array(),
        );
    }

    /**
     *
     */
    protected function init()
    {
        Bd_Log::debug("base page init...");
    }

    /**
     *
     */
    protected function call()
    {
        Bd_Log::debug("base page call ...");
    }

    /**
     * @return array
     */
    public function execute()
    {
        try {

            Bd_Log::trace(var_export($this->arrInput, true).':arrInput');
            $this->init();
            $this->call();
            Bd_Log::trace(var_export($this->arrOutput, true).":arrOutput");
        } catch(RuntimeException $err) {
            Bd_Log::debug($err->getMessage().":runtime exception");
            $this->arrOutput['ret'] = $err->getCode();
            $this->arrOutput['msg'] = $err->getMessage();
        } catch(Exception $err) {
            Bd_Log::warning($err->getMessage().":exception");
            $this->arrOutput['ret'] = $err->getCode();
            $this->arrOutput['msg'] = 'system error';
        }

        return $this->arrOutput;
    }
}