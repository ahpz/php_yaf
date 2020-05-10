<?php
/**
 * Filename: Server.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 17:04
 **/
require_once(__DIR__."/BaseTask.php");
class Server extends BaseTask
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
        $serv = new swoole_server('127.0.0.1', 8501, SWOOLE_BASE, SWOOLE_SOCK_TCP);
        $serv->set(array(
            'worker_num' => 4,
            //'daemonize' => true,
            'backlog' => 128,
        ));
        $serv->on('connect', function($serv, $fd) {
//            $serv->send($fd, 'Swoole: ' . $data);
//            $serv->close($fd);
            echo "client connect " .PHP_EOL;
        });
        $serv->on('receive', function($serv, $fd, $from_id, $data) {
            echo "receive data : " . $data . PHP_EOL;
            $serv->send($fd, 'Swoole: ' . $data);
            $serv->close($fd);
        });
        $serv->on('close', function($serv, $fd) {
            echo "Client close.".PHP_EOL;
        });
        $serv->start();

    }

}