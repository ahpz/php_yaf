<?php
/**
 * Filename: PluginException.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 19:16
 **/
class Validate_PluginException extends Exception
{
    /**
     * 初始化异常类
     *
     * @param int $errcode
     * @param string $errmsg
     * @return void
     */
    public function __construct($errcode, $errmsg = null)
    {
        if (empty($errmsg))
        {
            $errmsg = Validate_PluginApiError::errmsg($errcode);
        }
        $argv = func_get_args();
        if (!empty($argv[2]))
        {
            $errmsg = sprintf($errmsg, $argv[2]);
        }

        parent::__construct($errmsg, $errcode);
    }
}