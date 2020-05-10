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
 * CreateDate:2017-10-22 22:34
 **/
class Controller_Index extends Ap_Controller_Abstract
{
    public function init()
    {
        echo "---";
        Ap_Dispatcher::getInstance()->autoRender(false);
        Ap_Dispatcher::getInstance()->disableView();
    }
    public $actions = array(
        'index' => 'actions/Index.php',
    );
}