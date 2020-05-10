<?php
/**
 * Filename: RunTask.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-08-01 11:44
 **/
try {
    //php Console.php Vod ...
    Bd_Init::init('haitao');
    if ($argc < 2) {
        throw new RuntimeException("No task to assign.");//木有任务被 指定
    }
    $fileName = __DIR__.'/'.ucfirst(strtolower($argv[1]))."Task.php"; //当前路径下的脚本文件
    if (!file_exists($fileName) || !is_readable($fileName)) {
        throw new RuntimeException("the file:{$fileName} not exist or is not readable.");
    }
    require($fileName);

    //运行任务
    $className = ucfirst(strtolower($argv[1]));//类名

    $obj = new $className(array_slice($argv, 2));
    $obj->run();


} catch(Exception $err) {
    Bd_Log::warning($err->getMessage());
    echo "Exception:".$err->getMessage().PHP_EOL;
}