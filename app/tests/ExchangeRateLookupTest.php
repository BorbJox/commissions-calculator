<?php

namespace App;

use PHPUnit\Framework\TestCase;

class ExchangeRateLookupTest extends TestCase
{

    public function testGetRate()
    {
        $rateLookup = new ExchangeRateLookup();
        //Can't compare rate values, as it depends on a changing external API.
        //This tests if the API returns anything readable.
        $this->assertIsNumeric($rateLookup->getRate('USD'));
    }
}
