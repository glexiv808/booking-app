<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ErrorException extends \Exception
{
    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $statusCode = 400;

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param int $statusCode
     * @return void
     */
    public function __construct(?string $message = null, int $statusCode = 422)
    {
        $this->statusCode = $statusCode;
        $message = $message ?: 'Error';

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
            'status' => 'error',
            'message' => $this->getMessage(),
            'error_code' => 'error'
        ], $this->statusCode);
    }
}
