<?php
/**
 * Filename: PluginMain.php
 * The description of the file:
 * IDE : PhpStorm
 * ===============================================
 * Copy right 2017
 *
 * ===============================================
 * Author : pengzhi
 * Version:1.0.0
 * Encoding:UTF-8
 * CreateDate:2017-10-22 18:55
 **/
class Validate_PluginMain
{
    public static function preExecute($request)
    {
        $apiAuth = new Validate_PluginApiAuth($request);

        try {
            $apiAuth->execute();
        } catch (Validate_PluginException $err) {
            Bd_Log::warning($err->getMessage() . " : Exception");
            echo "Exception " . json_encode($err->getMessage());exit;
        }
    }

    public static function afterExecute($response)
    {

    }
}