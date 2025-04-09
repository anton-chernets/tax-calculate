<?php

namespace App\Services;

use App\Dto\ExchangeRateCollection;
use App\Dto\TransactionDto;
use App\Exceptions\BinCodeException;
use App\Helpers\CountryHelper;
use App\Helpers\CurrencyHelper;
use App\Providers\ProviderInterface;

class TaxCalculatorService
{
    private ProviderInterface $binCodeProvider;

    public function __construct(ProviderInterface $binCodeProvider)
    {
        $this->binCodeProvider = $binCodeProvider;
    }

    /**
     * @param TransactionDto $transaction
     * @param ExchangeRateCollection $allRates
     * @return float
     * @throws \Exception
     */
    public function calculate(TransactionDto $transaction, ExchangeRateCollection $allRates): float
    {
        $taxRate = $this->commissionRate($transaction, $allRates);

        if (CurrencyHelper::isEuroCurrency($transaction->currency) || $taxRate == 0) {
            $amountFixed = $transaction->amount;
        } else {
            $amountFixed = $transaction->amount / $taxRate;
        }

        $tax = $amountFixed * $this->commissionRateCoff($transaction);

        return $this->roundTax($tax);
    }

    /**
     * @param TransactionDto $transaction
     * @param ExchangeRateCollection $allRates
     * @return float
     */
    protected function commissionRate(TransactionDto $transaction, ExchangeRateCollection $allRates): float
    {
        return $allRates->getRateByCurrency($transaction->currency);
    }

    /**
     * @throws \Exception
     */
    protected function commissionRateCoff(TransactionDto $transaction): float
    {
        $bodyResponse = $this->binCodeProvider->getData($transaction);
        $binCode = $bodyResponse['country']['alpha2'] ?? null;
        if (is_null($binCode)) {
            throw new BinCodeException();
        }
        return CountryHelper::isEuroCountry($binCode) ? 0.01 : 0.02;
    }

    /**
     * @param float $tax
     * @return float
     */
    protected function roundTax(float $tax): float
    {
        return ceil($tax * 100) / 100;
    }
}