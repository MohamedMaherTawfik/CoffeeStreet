<?php

namespace App\Http\Controllers\api\cart;


trait apiResponse
{
    public function apiResponse($data=null, $message='')
    {
        $code=200;
        $array = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];
        return response()->json($array, $code);
    }

    public function sendError($error)
    {
        $code = 404;
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
