<?php
/**
 * Filename: ServerDemo.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-21 18:40
 **/
require_once(__DIR__."/BaseTask.php");
class Demo extends BaseTask
{
    /**
     *
     */
    protected function init()
    {
        //$this->client = new Erised_Client();
    }

    /**
     *php Console.php Demo
     */
    protected function exec()
    {
        echo <<<EOF
DEMO\n
EOF;


    }

}