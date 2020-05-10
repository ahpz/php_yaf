<?php
/**
 * Filename: PluginApiError.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 19:20
 **/
class Validate_PluginApiError
{
    // Basic errors
    const PLUGIN_EC_SUCCESS = 0;				//成功
    const PLUGIN_EC_UNKNOWN = 1000001;			//未知错误
    const PLUGIN_EC_PARAM_TPL = 1000002;		//产品线不合法
    const PLUGIN_EC_PARAM_SECRET_KEY = 1000003;	//秘钥不合法
    const PLUGIN_EC_METHOD = 1000004;			//请求api不存在
    const PLUGIN_EC_PERMISSION = 1000005;		//产品线未被授权
    const PLUGIN_EC_BAD_IP = 1000006;			//ip非法
    const PLUGIN_EC_PARAM_SIGNATURE = 1000007;	//签名错误
    const PLUGIN_EC_PARAM_INVALID = 1000008;	//参数不合法
    const PLUGIN_EC_DB_ERROR = 1000009;			//数据库错误
    const PLUGIN_EC_BAD_CSRF_TOKEN = 1000010;	//CSRF_TOKEN错误
    const PLUGIN_EC_USER_NOT_LOGIN = 1000011;	//用户未登录
    const PLUGIN_EC_USER_AUTH_FAIL = 1000012;   //用户权限验证失败
    const PLUGIN_EC_PARAM_MISSING = 1000013;
    //Api errors
    const PLUGIN_EC_FILE_NOT_FOUND = 1000101;	//配置文件未找到


    /**
     * 错误码对应的错误信息数组
     * @var array
     */
    public static $arrPluginErrorDesc = array (
        // Basic error message
        self::PLUGIN_EC_SUCCESS 				=> 'Success',
        self::PLUGIN_EC_UNKNOWN 				=> 'Unknown error',
        self::PLUGIN_EC_PARAM_TPL 		    	=> 'Invalid tpl',
        self::PLUGIN_EC_PARAM_SECRET_KEY     	=> 'Invalid secret key',
        self::PLUGIN_EC_METHOD 					=> 'Unsupported internal api url',
        self::PLUGIN_EC_PERMISSION 				=> 'No permission to use method',
        self::PLUGIN_EC_BAD_IP 					=> 'Unauthorized client IP address [%s]',
        self::PLUGIN_EC_PARAM_SIGNATURE      	=> 'Incorrect signature',
        self::PLUGIN_EC_PARAM_INVALID 			=> 'Invalid parameter [%s]',
        self::PLUGIN_EC_DB_ERROR 				=> 'DB error',
        self::PLUGIN_EC_BAD_CSRF_TOKEN          => 'Invalid csrf token',
        self::PLUGIN_EC_USER_NOT_LOGIN          => 'User not login',
        self::PLUGIN_EC_USER_AUTH_FAIL          => 'User auth fail',
        self::PLUGIN_EC_PARAM_MISSING 			=> 'Missing parameter [%s]',

        // Api error message
        self::PLUGIN_EC_FILE_NOT_FOUND => 'file not found',
    );


    /**
     * 根据错误码返回相应的错误信息
     *
     * @param  int $errcode
     * @return string
     */
    public static function errmsg($errcode)
    {
        if (isset(self::$arrPluginErrorDesc[$errcode])) {
            return self::$arrPluginErrorDesc[$errcode];
        } else {
            return self::$arrPluginErrorDesc[self::PLUGIN_EC_UNKNOWN];
        }
    }

}