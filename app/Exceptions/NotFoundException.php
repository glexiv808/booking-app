<?php

namespace App\Exceptions;

class NotFoundException extends ApiException
{
    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $statusCode = 404;

    /**
     * The error code.
     *
     * @var string
     */
    protected $errorCode = 'not_found';

    /**
     * Get the default error message.
     *
     * @return string
     */
    protected function getDefaultMessage(): string
    {
        return 'The requested resource was not found.';
    }
}
