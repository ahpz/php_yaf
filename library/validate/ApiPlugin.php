<?php
/**
 * Filename: ApiPlugin.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 * (参数,url ...) 验证插件
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 18:26
 **/
class Validate_ApiPlugin extends Ap_Plugin_Abstract
{


    /**
     *
     * @param Ap_Request_Abstract $request
     * @param Ap_Response_Abstract $response
     */
    public function routerStartup(Ap_Request_Abstract $request, Ap_Response_Abstract $response)
    {

    }

    /**
     * @param Ap_Request_Abstract $request
     * @param Ap_Response_Abstract $response
     */
    public function dispatchLoopStartup(Ap_Request_Abstract $request, Ap_Response_Abstract $response)
    {

    }
    /**
     * 在分发之前执行
     * @param $request
     * @param $response
     * @return null
     */
    public function preDispatch(Ap_Request_Abstract $request, Ap_Response_Abstract $response)
    {
        Validate_PluginMain::preExecute($request);
    }

    /**
     * 在分发之后执行
     * @param $request
     * @param $response
     * @return null
     */
    public function postDispatch(Ap_Request_Abstract $request, Ap_Response_Abstract $response)
    {

        Validate_PluginMain::afterExecute($response);
    }

    /**
     * @param Ap_Request_Abstract $request
     * @param Ap_Response_Abstract $response
     */
    public function dispatchLoopShutdown(Ap_Request_Abstract $request, Ap_Response_Abstract $response)
    {

    }

    /**
     * @param Ap_Request_Abstract $request
     * @param Ap_Response_Abstract $response
     */
    public function routerShutdown(Ap_Request_Abstract $request, Ap_Response_Abstract $response)
    {

    }

    /**
     * @param Ap_Request_Abstract $request
     * @param Ap_Response_Abstract $response
     */
    public function preResponse(Ap_Request_Abstract $request, Ap_Response_Abstract $response)
    {

    }
}