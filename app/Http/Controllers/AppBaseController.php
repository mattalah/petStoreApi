<?php

namespace App\Http\Controllers;


/**
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message, $code = 200)
    {
        return response()->json([
            'result' => $result,
            'message' => $message,
        ], $code);
    }

    public function sendError($message, $code = 404, $data = [])
    {
        return response()->json([
            'errors' => $data,
            'message' => $message,
            'data' => [],
        ], $code);
    }

    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
