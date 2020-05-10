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
 * CreateDate:2017-10-22 22:39
 **/
class Service_Page_Index extends Service_Page_Base
{
    protected function init()
    {

    }
    protected function call()
    {
        $this->arrOutput['content'] = "hello world . input args :" . json_encode($this->arrInput) ;
    }
}