<?php

namespace App\Helpers;

class apiFormat
{

    protected $response = [
        'code' => 'null',
        'message' => 'null',
        'data' => 'null'

    ];

    public static function createApi($code, $message, $data)
    {

        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['code']);
    }
}
