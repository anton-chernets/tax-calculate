<?php

namespace App\Exceptions;

class ExchangeRateException extends \Exception
{
    public function __construct(
        $message = 'default exchange rate exception error message',
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}