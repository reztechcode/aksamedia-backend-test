<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function ok(string $message, array $data = [], ?array $pagination = null): JsonResponse
    {
        $res = [
            'status' => 'success',
            'message' => $message,
            'data' => (object) $data,
        ];
        if ($pagination !== null) $res['pagination'] = (object) $pagination;
        return response()->json($res);
    }

    protected function fail(string $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => (object) [],
        ], $code);
    }
}
