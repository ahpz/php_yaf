<?php
/**
 * Filename: Client.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 17:06
 **/
require_once(__DIR__."/BaseTask.php");
class Client extends BaseTask
{
    /**
     *
     */
    protected function init()
    {
        //$this->client = new Erised_Client();
    }

    /**
     *
     */
    protected function exec()
    {
        $client = new swoole_client(SWOOLE_SOCK_TCP);
        if ( ! $client->connect('127.0.0.1', 8501, -1) ) {
            exit("connect failed : " . $client->errCode);
        }
        $client->send("hello world \n");
        echo $client->recv();
        $client->close();

    }

}