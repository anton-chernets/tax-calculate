<?php

use App\Providers\ExchangeRatesProvider;
use App\Dto\ExchangeRateCollection;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;

class ExchangeRatesProviderTest extends TestCase
{
    /**
     * Set up the environment before each test.
     */
    public function setUp(): void
    {
        parent::setUp();
        /* Load Environment */
        Dotenv::createImmutable(__DIR__ . '/../')->load();
    }

    /**
     * Test successful retrieval of exchange rates from a file.
     * @throws GuzzleException|Exception
     */
    public function testGetRates()
    {
        $filePath = __DIR__ . '/mocks/exchange_rates.json';

        $mock = new MockHandler([
            new Response(200, [], file_get_contents($filePath))
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $provider = new ExchangeRatesProvider($client);
        $rates = $provider->getRates();

        $this->assertInstanceOf(ExchangeRateCollection::class, $rates);

        $result = true;
        $stackCodeRates = [
            'USD' => 1.102992, 'EUR' => 1.0, 'JPY' => 161.684817, 'GBP' => 0.837518
        ];
        foreach ($stackCodeRates as $code => $rate) {
            if ($rate !== $rates->getRateByCurrency($code)) {
                $result = false;
                break;
            }
        }
        $this->assertTrue($result);
    }
}
