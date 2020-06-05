<?php


namespace App;


use App\Exceptions\APIErrorException;
use App\Exceptions\APIMIssingDataException;

class ExchangeRateLookup implements ExchangeRateProvider
{
    public $rates = array();
    public $base;

    public function __construct($baseCurrency = 'EUR')
    {
        $this->base = $baseCurrency;
        $this->loadExchangeRates($baseCurrency);
    }

    protected function loadExchangeRates($baseCurrency)
    {
        $content = file_get_contents('https://api.exchangeratesapi.io/latest');
        if ($content === false) {
            throw new APIErrorException('Exchange rates API could not be reached.');
        }
        $content = json_decode($content, true);
        if (isset($content['error'])) {
            throw new APIErrorException('Failed to get exchange rates. Error returned: "' . $content['error'] . '"');
        } elseif (isset($content['rates'])) {
            $this->rates = $content['rates'];
        }
    }

    public function getRate(string $currency)
    {
        if ($currency == $this->base) {
            return 1;
        } elseif (isset($this->rates[$currency])) {
            return $this->rates[$currency];
        } else {
            throw new APIMIssingDataException('Exchange rate from ' . $currency . ' to ' . $this->base . ' not found.');
        }
    }
}