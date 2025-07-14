<?php 

namespace App\Services;

use App\Models\ApiLog;

class LogApiCallService
{
    public static function success(string $source, string $endpoint, $request, $response = null)
    {
        ApiLog::create([
            'source' => $source,
            'endpoint' => $endpoint,
            'request_payload' => json_encode($request),
            'response_payload' => json_encode('Success'),
            'success' => true,
        ]);
    }

    public static function failure(string $source, string $endpoint, $request, string $error)
    {
        ApiLog::create([
            'source' => $source,
            'endpoint' => $endpoint,
            'request_payload' => json_encode($request),
            'success' => false,
            'error_message' => $error,
        ]);
    }
}
