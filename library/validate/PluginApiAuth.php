<?php
/**
 * Filename: PluginApiAuth.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 20:02
 **/
class Validate_PluginApiAuth
{
    private $uri = null;
    private $request = null;
    private $params = array();


    public function __construct($request)
    {
        $this->request= $request;
        $this->uri    = parse_url(@$_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->params = array_merge($_GET, $_POST);
    }

    /**
     *
     */
    public function execute()
    {
        //请求uri 验证
        $this->checkUri();
        //请求参数处理 预处理
        $this->processParams();
        //请求参数验证
        $this->checkParams();
        //权限,ip 待优化
    }

    /**
     * @throws Validate_PluginException
     */
    private function checkUri()
    {
        $uri = $this->uri;

        if ( isset(Validate_PluginApiConfig::$whiteList[$uri]) ) {
            //白名单
        } elseif ( isset(Validate_PluginApiConfig::$blackList[$uri]) ) {
            //和名单
            throw new Validate_PluginException(Validate_PluginApiError::PLUGIN_EC_METHOD);//
        } elseif ( ! isset(Validate_PluginApiConfig::$apiConf[$uri]) ) {
            //不支持的uri
            throw new Validate_PluginException(Validate_PluginApiError::PLUGIN_EC_METHOD);//
        } else {

        }

    }

    /**
     * @return array
     */
    private function processParams()
    {
        $checkRules = Validate_PluginApiConfig::$pluginApiParamCheckRules;
        //预处理参数
        foreach ($this->params as $key => $value) {
            if (isset($checkRules[$key]['hook_start']) ) {
                $this->params[$key] = call_user_func($checkRules[$key]['hook_start'], $value);
            }
            $this->request->setParam($key, $value);
        }

        return $this->params;
    }

    /**
     * @throws Validate_PluginException
     */
    private function checkParams()
    {
        //参数存在性判断
        if ( isset(Validate_PluginApiConfig::$apiConf[$this->uri]['param_need']) ) {
            $param_need = Validate_PluginApiConfig::$apiConf[$this->uri]['param_need'];
            foreach ($param_need as $param) {
                if ( !isset($this->params[$param]) ) {
                    throw new Validate_PluginException(Validate_PluginApiError::PLUGIN_EC_PARAM_MISSING, null, $param);
                }
            }
        }
        //参数内容验证
        $checkRules = Validate_PluginApiConfig::$pluginApiParamCheckRules;
        foreach ($this->params as $key => $value) {
            if ( isset($checkRules[$key]['check_func']) ) {
                $params = $checkRules[$key]['param'];
                array_unshift($params, $value);
                if ( ! call_user_func_array($checkRules[$key]['check_func'], $params) ) {
                    throw new Validate_PluginException(Validate_PluginApiError::PLUGIN_EC_PARAM_INVALID, null, $key);
                }//可能存在引用传递影响效率
            }
        }

    }

}