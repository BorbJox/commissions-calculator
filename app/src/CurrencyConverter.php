<?php


namespace App;


class CurrencyConverter
{
    public static function getAmountInCurrency($amount, string $currency, ExchangeRateProvider $provider)
    {
        return $amount / $provider->getRate($currency);
    }
}