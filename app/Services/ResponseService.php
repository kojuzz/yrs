<?php

namespace App\Services;


class ResponseService
{
    public static function success($data, $message = 'success', $code = 200) {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public static function fail($message = 'fail', $code = 422) {
        return response()->json([
            'message' => $message
        ], $code);
    }
}