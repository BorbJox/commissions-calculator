<?php

namespace App;

use PHPUnit\Framework\TestCase;

class BinLookupTest extends TestCase
{
    /**
     * @dataProvider binProvider
     */
    public function testGetCardCountry($bin, $expected)
    {
        $binLookup = new BinLookup();
        //Not sure if BIN number countries ever change. Might not be appropriate to check them here.
        $this->assertSame($expected, $binLookup->getCardCountry($bin));
    }

    public function binProvider()
    {
        return [
            ['4745030', 'GB'],
            ['45717360', 'DK']
        ];
    }
}
