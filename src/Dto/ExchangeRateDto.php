<?php

namespace App\Dto;

class ExchangeRateDto
{
    public string $currency;
    public float $rate;

    public function __construct(string $currency, float $rate)
    {
        $this->currency = $currency;
        $this->rate = $rate;
    }

    public static function fromArray(string $currency, float $rate): self
    {
        return new self($currency, $rate);
    }
}
