<?php

namespace App\Services;

use App\Dto\TransactionDto;

class TransactionService
{
    public static function getFileTransactions($fileName): array
    {
        $fileReader = new FileReaderService($fileName);

        $data = $fileReader->convertFileToArray();

        return TransactionDto::fromJsonLines($data);
    }
}