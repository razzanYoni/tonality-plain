<?php

namespace exceptions;

use RuntimeException;
use Throwable;

class InvalidFileFormatException extends RuntimeException
{
    public function __construct($message = 'File format is not supported.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}