<?php
/**
 * Filename: Index.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 22:35
 **/
class Action_Index extends Ap_Action_Abstract
{
    public function execute()
    {

        phpinfo();exit;
        $args = $this->getRequest()->getParams();//参数验证插件 合并GET POST 且验证后的参数
        //$this->getResponse()->setBody(json_encode($args));
        $this->getResponse()->setBody("<h1>hello world</h1>");
        //$this->getResponse()->setBody('---');
        $obj  = new Service_Page_Index($args);
        //echo json_encode($obj->execute());
        //exit;
    }
}