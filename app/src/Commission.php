<?php


namespace App;


class Commission
{

    protected static $commissionRateEU = 0.01;
    protected static $commissionRateOther = 0.02;

    public static function calculateCommission(string $country, float $amount)
    {
        if (self::isCountryEU($country)) {
            $commission = $amount * self::$commissionRateEU;
        } else {
            $commission = $amount * self::$commissionRateOther;
        }

        return self::roundUp($commission);
    }

    protected static function roundUp($amount)
    {
        //Rounding up. Two digits after decimal.
        $rounded = $amount * 100;
        $rounded = intval($rounded * 10) / 10; //Correcting floating point inaccuracy
        $rounded = ceil($rounded) / 100;

        return $rounded;
    }


    protected static function isCountryEU(string $country)
    {
        switch($country) {
            case 'AT':
            case 'BE':
            case 'BG':
            case 'CY':
            case 'CZ':
            case 'DE':
            case 'DK':
            case 'EE':
            case 'ES':
            case 'FI':
            case 'FR':
            case 'GR':
            case 'HR':
            case 'HU':
            case 'IE':
            case 'IT':
            case 'LT':
            case 'LU':
            case 'LV':
            case 'MT':
            case 'NL':
            case 'PO':
            case 'PT':
            case 'RO':
            case 'SE':
            case 'SI':
            case 'SK':
                return true;
            default:
                return false;
        }
    }
}