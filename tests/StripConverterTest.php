<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class StripConverterTest extends TestCase
{
    public function convertProvider()
    {
        return [
            [
                '$cfeg$fff๐u1 $666ツ',
                'g๐u1 ツ'
            ],
            [
                '$000$$000',
                '$000'
            ],
        ];
    }

    /**
     * @dataProvider convertProvider
     */
    public function testConvert($input, $expected)
    {
        $strip = new \Manialib\Formatting\Converter\Strip();

        $this->assertEquals($expected, $strip->setInput(new \Manialib\Formatting\ManiaplanetString($input))->getOutput());
    }
}
