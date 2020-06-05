<?php

namespace App;

use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{

    /**
     * @dataProvider ratesProvider
     */
    public function testGetAmountInCurrency($amount, $currency, $expected)
    {
        $stub = $this->createStub(ExchangeRateProvider::class);
        $map = [
            ['EUR', 1],
            ['USD', 1.125],
            ['GBP', 0.89685],
        ];
        $stub->method('getRate')
            ->will($this->returnValueMap($map));

        $convertedAmount = CurrencyConverter::getAmountInCurrency($amount, $currency, $stub);
        $this->assertSame($convertedAmount, $expected);
    }

    public function ratesProvider()
    {
        return [
            [122.23, 'GBP', (122.23 / 0.89685)],
            [100.0, 'EUR', 100.0],
            [801.0, 'USD', 712.0],
        ];
    }
}
