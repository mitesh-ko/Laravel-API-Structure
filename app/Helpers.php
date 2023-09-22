<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('apiResponse')) {
    /**
     * API response structure method.
     *
     * @param bool $status
     * @param string $message
     * @param mixed $data
     * @param int $httpCode
     * @return JsonResponse
     */
    function apiResponse(bool $status, string $message, mixed $data, int $httpCode = 200): JsonResponse
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data'    => $data,
        ];
        return response()->json($response, $httpCode);
    }
}

if (!function_exists('apiException')) {
    /**
     * API exception response method.
     *
     * @param $e
     * @return JsonResponse
     */
    function apiException($e): JsonResponse
    {
        Log::debug("\nCode: " . $e->getCode() . "\nMessage: " . $e->getMessage() . "\nLine: " . $e->getLine());
        return apiResponse(false, 'Something went wrong!', [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
