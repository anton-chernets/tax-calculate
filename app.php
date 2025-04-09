<?php

require __DIR__ . '/vendor/autoload.php';

use App\Providers\ExchangeRatesProvider;
use App\Providers\BinCodeProvider;
use App\Services\TaxCalculatorService;
use App\Services\TransactionService;
use App\Validators\InputFileValidator;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

/* Get Filename */
$fileName = InputFileValidator::validateFilename($argv);

/* Load Environment */
Dotenv::createImmutable(__DIR__)->load();

/* Start App */
$client = new Client();
try {
    $rates = (new ExchangeRatesProvider($client))->getRates();
} catch (Exception $e) {
    exit("error message: {$e->getMessage()}\n");
}

foreach (TransactionService::getFileTransactions($fileName) as $transaction) {
    try {
        echo (new TaxCalculatorService(
            new BinCodeProvider($client)
        ))->calculate($transaction, $rates);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    print "\n";
}
/* Finish App */
