<?php

namespace exceptions;

use Exception, Throwable;

class InternalServerErrorException extends Exception
{
  public function __construct($message = "", $code = 0, Throwable $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}