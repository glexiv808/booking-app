<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecordExistsException extends Exception
{
    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $statusCode = 409;

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param int $statusCode
     * @return void
     */
    public function __construct(?string $message = null, int $statusCode = 409)
    {
        $this->statusCode = $statusCode;
        $message = $message ?: 'The record already exists.';

        parent::__construct($message);
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => $this->statusCode,
            'message' => $this->getMessage(),
            'error_code' => 'record_exists'
        ], $this->statusCode);
    }
}
