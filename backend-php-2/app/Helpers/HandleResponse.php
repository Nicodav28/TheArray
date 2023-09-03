<?php

namespace App\Helpers;

class HandleResponse
{
    public static function success($traceCode, $data, $message = null, $code = 200)
    {
        return response()->json([
            'error' => false,
            'traceCode' => $traceCode,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($traceCode, $message, $code)
    {
        return response()->json([
            'error' => true,
            'traceCode' => $traceCode,
            'message' => $message,
        ], $code);
    }
}
