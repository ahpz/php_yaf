<?php
/**
 * Filename: PluginApiConfig.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 19:19
 **/
class Validate_PluginApiConfig
{
    public static $whiteList = array();//白名单url
    public static $blackList = array();//黑名单
    /**
     * @var array
     */
    public static $apiConf = array(
        //搜索请求，给出相关攻略资讯的搜索结果集
        '/demo/index/index' => array(
            'param_need'     => array('a'),
        ),
    );

    /**
     * @var array
     */
    public static $pluginApiParamCheckRules = array(
        'a' => array(
            'hook_start'    => 'trim',
            'check_func'    => 'Validate_PluginApiUtil::checkStrlenRange',
            'param'         => array(2,3),
        ),
    );
}