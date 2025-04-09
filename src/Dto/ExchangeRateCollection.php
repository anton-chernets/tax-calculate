<?php

namespace App\Dto;

class ExchangeRateCollection
{
    /** @var ExchangeRateDto[] */
    private array $items = [];

    public function __construct(array $rates)
    {
        foreach ($rates as $currency => $rate) {
            if (!is_string($currency) || !is_numeric($rate)) {
                continue;
            }

            $this->items[] = new ExchangeRateDto($currency, (float) $rate);
        }
    }

    public function getRateByCurrency(string $currency): ?float
    {
        foreach ($this->items as $item) {
            if ($item->currency === $currency) {
                return $item->rate;
            }
        }
        return null;
    }
}
