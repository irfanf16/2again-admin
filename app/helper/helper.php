<?php

if (!function_exists('responseNow')) {
    function responseNow($code, $message, $error, $statusCode = 400)
    {
        response()->json(['ResponseCode' => $code, 'ResponseMessage' => $message, 'error' => [$error]], $statusCode)->send();
        die;
    }
}
