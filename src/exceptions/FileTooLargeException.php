<?php

namespace exceptions;

use RuntimeException;
use Throwable;

class FileTooLargeException extends RuntimeException
{
    public function __construct($message = 'File size exceeds the allowed limit.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}