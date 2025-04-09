<?php

namespace App\Providers;

use App\Dto\ExchangeRateCollection;
use App\Exceptions\ExchangeRateException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class ExchangeRatesProvider extends BaseProvider implements ProviderInterface
{
    /**
     * @throws Exception|GuzzleException
     */
    public function getRates(): ExchangeRateCollection
    {
            $exchangeRateData = $this->getData();
            $responseRates = $exchangeRateData['rates'] ?? null;
            if(is_array($responseRates)) {
                return new ExchangeRateCollection($responseRates);
            }
            throw new ExchangeRateException();
    }

    /**
     * @throws Exception|GuzzleException
     */
    public function getData(): array
    {
        $url = $_ENV['EXCHANGE_RATES_API_URL'];
        $apiKey = $_ENV['EXCHANGE_RATES_API_KEY'];

        $requestBody = $apiKey ? [
            'query' => [
                'access_key' => $_ENV['EXCHANGE_RATES_API_KEY']
            ]
        ] : [];

        return $this->getBodyResponse($url, $requestBody);
    }

    /**
     * @param string $errorMessage
     * @return Exception
     */
    public static function getProviderException(string $errorMessage): Exception
    {
        return new ExchangeRateException($errorMessage);
    }

    public static function getErrorMessage(): string
    {
        return 'api exchange rate response error!';
    }
}