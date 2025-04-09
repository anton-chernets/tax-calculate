<?php

namespace App\Providers;

use Exception;

interface ProviderInterface
{
    static function getErrorMessage(): string;
    static function getProviderException(string $errorMessage): Exception;
}