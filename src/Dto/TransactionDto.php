<?php

namespace App\Dto;

class TransactionDto
{
    public string $bin;
    public float $amount;
    public string $currency;

    public function __construct(string $bin, float $amount, string $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function fromStdClass(\stdClass $data): self
    {
        return new self(
            $data->bin,
            (float) $data->amount,
            $data->currency
        );
    }

    public static function fromJsonLines(array $jsonLines): array
    {
        return array_map(function (string $json) {
            return self::fromStdClass(json_decode($json));
        }, $jsonLines);
    }
}
