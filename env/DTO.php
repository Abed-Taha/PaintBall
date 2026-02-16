<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class DTO
{
    //fetch data methods
    public static function message($status, $message)
    {
        return json_encode(array("status" => $status, "message" => $message));
    }

    public static function success($message, $status = 200)
    {
        return self::message($status, $message);
    }

    public static function error($message, $status = 401)
    {
        return self::message($status, $message);
    }
    // -- end of fetch data methods -- //

    public static function session_success($message, $data = [])
    {
        self::session('success', $message, $data);
    }
    public static function session_error($message, $data = [])
    {
        self::session('error', $message, $data);
    }

    public static function session($status, $message, $data = [])
    {
        $_SESSION['response'] = ['status' => $status, "message" => $message, "data" => $data];
    }
}
