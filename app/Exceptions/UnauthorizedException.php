<?php

namespace App\Exceptions;

class UnauthorizedException extends ApiException
{
    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $statusCode = 401;

    /**
     * The error code.
     *
     * @var string
     */
    protected $errorCode = 'unauthorized';

    /**
     * Get the default error message.
     *
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return 'Unauthorized. Authentication required.';
    }
}
