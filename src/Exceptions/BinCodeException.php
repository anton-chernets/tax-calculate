<?php

namespace App\Exceptions;

class BinCodeException extends \Exception
{
    public function __construct(
        $message = 'default bin code exception error message',
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}