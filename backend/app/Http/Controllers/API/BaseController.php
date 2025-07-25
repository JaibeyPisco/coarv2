<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

 class BaseController extends Controller{
    public function sendResponse($result, $message=''): JsonResponse
    {

        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

        public function sendError($error, $errorMessages = [], $code = 400): JsonResponse
    {

        $response = [
            'success' => false,
            'message' => $error
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
 }
