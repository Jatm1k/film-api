<?php

namespace App\Services\API\v1\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

class ExceptionsService
{
    /**
     * @param string $message
     * @param int $statusCode
     * @return void
     */
    public function make(string $message, int $statusCode): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $message
            ], $statusCode)
        );
    }
}
