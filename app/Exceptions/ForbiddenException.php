<?php

namespace App\Exceptions;

class ForbiddenException extends ApiException
{
    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $statusCode = 403;

    /**
     * The error code.
     *
     * @var string
     */
    protected $errorCode = 'forbidden';

    /**
     * Get the default error message.
     *
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return 'Forbidden. You do not have permission to access this resource.';
    }
}
