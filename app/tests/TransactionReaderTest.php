<?php

namespace App;

use PHPUnit\Framework\TestCase;

class TransactionReaderTest extends TestCase
{
    /**
     * @dataProvider fileProvider
     */
    public function testReadFile($filename, $expected)
    {
        $this->assertSame($expected, TransactionReader::readFile($filename));
    }

    public function fileProvider()
    {
        return [
            ['test_good_input.txt', [
                ["bin"=>"45717360","amount"=>"100.00","currency"=>"EUR"],
                ["bin"=>"4745030","amount"=>"2000.00","currency"=>"GBP"]
            ]],
            ['test_bad_input.txt', []]
        ];
    }
}
