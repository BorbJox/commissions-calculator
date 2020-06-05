<?php


namespace App;


interface CardCountryProvider
{
    public function getCardCountry(string $bin);
}