<?php

namespace App\Providers;

use App\Dto\TransactionDto;
use App\Exceptions\BinCodeException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class BinCodeProvider extends BaseProvider implements ProviderInterface
{
    /**
     * @throws Exception
     */
    public function getData(TransactionDto $transaction): array
    {
        $url = $_ENV['BIN_API_URL'];

        try {
            return $this->getBodyResponse($url, $this->getBodyRequest(), $transaction->bin);
        } catch (GuzzleException $e) {
            $this->logger->error($url, [$e->getMessage()]);
            throw new BinCodeException($e->getMessage());
        }
    }

    /**
     * @param string $errorMessage
     * @return Exception
     */
    public static function getProviderException(string $errorMessage): Exception
    {
        return new BinCodeException($errorMessage);
    }

    public static function getErrorMessage(): string
    {
        return 'api country code response error!';
    }

    public static function getApiKey(): string
    {
        return $_ENV['BIN_API_KEY'];
    }
}