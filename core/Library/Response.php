<?php

/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 04.02.2016
 * Time: 13:50
 */
class Response
{
    const STATUS_OK = 200;
    const STATUS_NOT_MODIFIED = 304;
    const STATUS_FORBIDDEN = 403;

    /**
     * @param array|bool $args
     */
    public static function ReturnJson($args = false)
    {
        header('Content-type: application/json');
        if($args) echo json_encode($args);
    }
    public static function ReturnCode($code)
    {
        if (!function_exists('http_response_code')) {
            header('Status: '.$code, true, $code);
        } else {
            http_response_code($code);
        }
    }
}