<?php

use App\Dto\ExchangeRateCollection;
use App\Dto\TransactionDto;
use App\Providers\BinCodeProvider;
use App\Services\TaxCalculatorService;
use PHPUnit\Framework\TestCase;

class TaxCalculateServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCalculateForEuroCurrency(): void
    {
        $transaction = new TransactionDto('45717360', 100.00, 'EUR');

        $rates = $this->createMock(ExchangeRateCollection::class);
        $provider = $this->createMock(BinCodeProvider::class);

        $taxService = $this->getMockBuilder(TaxCalculatorService::class)
            ->setConstructorArgs([$provider])
            ->onlyMethods(['commissionRate', 'commissionRateCoff'])
            ->getMock();

        $taxService->method('commissionRate')->willReturn(0.0);
        $taxService->method('commissionRateCoff')->willReturn(0.01);

        $result = $taxService->calculate($transaction, $rates);

        $this->assertEquals(1.0, $result);
    }

    /**
     * @throws Exception
     */
    public function testCalculateForNonEuroCurrency(): void
    {
        $transaction = new TransactionDto('45717360', 200.00, 'USD');

        $rates = $this->createMock(ExchangeRateCollection::class);
        $provider = $this->createMock(BinCodeProvider::class);

        $taxService = $this->getMockBuilder(TaxCalculatorService::class)
            ->setConstructorArgs([$provider])
            ->onlyMethods(['commissionRate', 'commissionRateCoff'])
            ->getMock();

        $taxService->method('commissionRate')->willReturn(2.0);
        $taxService->method('commissionRateCoff')->willReturn(0.03);

        $result = $taxService->calculate($transaction, $rates);

        $this->assertEquals(3.0, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testRoundTax()
    {
        $provider = $this->createMock(BinCodeProvider::class);
        $calculator = new TaxCalculatorService($provider);
        $reflection = new ReflectionClass($calculator);
        $method = $reflection->getMethod('roundTax');
        $method->setAccessible(true);

        $this->assertSame(1.24, $method->invoke($calculator, 1.234));
        $this->assertSame(1.25, $method->invoke($calculator, 1.245));
        $this->assertSame(2.00, $method->invoke($calculator, 1.995));
        $this->assertSame(0.01, $method->invoke($calculator, 0.001));
        $this->assertSame(5.10, $method->invoke($calculator, 5.099));
    }
}
