<?php

use App\BinLookup;
use App\Commission;
use App\CurrencyConverter;
use App\Exceptions\APIErrorException;
use App\ExchangeRateLookup;
use App\TransactionReader;

require 'vendor/autoload.php';

try {
    $transactions = TransactionReader::readFile($argv[1]);
    $exchangeRates = new ExchangeRateLookup();
    $binLookup = new BinLookup();
} catch (Exception $e) {
    //Cannot function without transactions and exchange rates.
    echo $e->getMessage();
    exit;
}

foreach ($transactions as $transaction) {
    if (!isset($transaction['amount']) || !isset($transaction['currency']) || !isset($transaction['bin'])) {
        //Displaying error and moving on to next transaction.
        echo 'Missing transaction data.'.PHP_EOL;
        continue;
    }

    try {
        $eurAmount = CurrencyConverter::getAmountInCurrency(
            $transaction['amount'],
            $transaction['currency'],
            $exchangeRates
        );

        $card_country = $binLookup->getCardCountry($transaction['bin']);
    } catch (APIErrorException $e) {
        //API inaccessible. Stop checking further transactions.
        echo $e->getMessage().PHP_EOL;
        break;
    } catch (Exception $e) {
        //Displaying error and moving on to next transaction.
        echo $e->getMessage().PHP_EOL;
        continue;
    }

    $commission = Commission::calculateCommission($card_country, $eurAmount);
    echo $commission.PHP_EOL;
}