<?php


namespace App;


interface ExchangeRateProvider
{
    public function getRate(string $currency);
}