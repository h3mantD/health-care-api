<?php

if (!function_exists('errorResponse')) {
    function errorResponse($message)
    {
        return response()->json(['status' => false, 'message' => $message]);
    }
}
