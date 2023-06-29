<?php

function lypsisJsonResponse(int $statusCode, string $message, $data = null)
{
    $response = [
        'status' => $statusCode,
        'message' => $message,
    ];

    if (!is_null($data)) {
        $response['data'] = $data;
    }

    return response()->json($response, $statusCode);
}