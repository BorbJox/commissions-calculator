<?php

namespace App;

use PHPUnit\Framework\TestCase;

class CommissionTest extends TestCase
{

    /**
     * @dataProvider transactionProvider
     */
    public function testCalculateCommission($country, $amount, $expected)
    {
        $this->assertSame($expected, Commission::calculateCommission( $country, $amount));
    }

    public function transactionProvider()
    {
        return [
            ['LT', 100, 1.0],
            ['DK', 45.587436, 0.46],
            ['US', 111, 2.22],
            ['foobar', 123.45, 2.47]
        ];
    }

}
