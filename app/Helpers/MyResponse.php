<?php

namespace App\Helpers;

use App\Repository\Teqrypt;
use Illuminate\Http\JsonResponse;

class MyResponse
{
    public static function staticSuccess($message = '', $data = null): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data
        ]);
    }

    public static function success($message = '', $data = null): JsonResponse
    {
        if ( !is_null($data) ) {
            $data = (new Teqrypt)->encrypt(json_encode($data));
            $data = $data['success'] === true ? $data['data'] : null;
        }

        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data
        ]);
    }

    public static function failed($message = '', $data = null, $code = 200): JsonResponse
    {
        if ( !is_null($data) ) {
            $data = (new Teqrypt)->encrypt(json_encode($data));

            $data = $data['success'] === true ? $data['data'] : null;
        }

        return response()->json([
            'success'   => false,
            'message'   => $message,
            'data'      => $data
        ], $code);
    }
}
