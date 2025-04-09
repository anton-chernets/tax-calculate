<?php

namespace App\Providers;

use App\Logger\LoggerFactory;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;

class BaseProvider
{
    protected Client $client;
    protected ?Logger $logger;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->logger = LoggerFactory::createLogger();
    }

    /**
     * @param string $url
     * @param array $requestBody
     * @param string $action
     * @return array
     * @throws GuzzleException
     * @throws Exception
     */
    public function getBodyResponse(string $url, array $requestBody, string $action = ''): array
    {
        $response = $this->client->get($url . $action, $requestBody);
        if ($response->getStatusCode() == 200) {

            $responseBody = json_decode($response->getBody(), true);
            $this->logger->debug($url, $responseBody);

            return $responseBody;
        } else {
            $errorMessage = static::getErrorMessage();
            $this->logger->error($errorMessage);
            throw static::getProviderException($errorMessage);
        }
    }
}