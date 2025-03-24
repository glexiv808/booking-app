<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

abstract class ApiException extends Exception
{
    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $statusCode = 500;

    /**
     * The error code.
     *
     * @var string
     */
    protected $errorCode = 'api_error';

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param int|null $statusCode
     * @param Throwable|null $previous
     * @return void
     */
    public function __construct(?string $message = null, ?int $statusCode = null, Throwable $previous = null)
    {
        if ($statusCode !== null) {
            $this->statusCode = $statusCode;
        }

        $message = $message ?: $this->getDefaultMessage();

        parent::__construct($message, 0, $previous);
    }

    /**
     * Get the default error message.
     *
     * @return string
     */
    abstract protected function getDefaultMessage(): string;

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
            'error_code' => $this->errorCode
        ], $this->statusCode);
    }

    /**
     * Get the HTTP status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get the error code.
     *
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
