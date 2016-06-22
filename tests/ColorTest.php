<?php

use Manialib\Formatting\Color;

class ColorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider rgb24ToStringProvider
     */
    public function testStringToRgb12String($input, $expected)
    {
        $rgb24 = Color::stringToRgb24($input);

        $rgb12 = Color::rgb24ToRgb12($rgb24);

        $this->assertEquals($expected, Color::rgb12ToString($rgb12));
    }

    public function rgb24ToStringProvider()
    {
        return [
            [
                'CC0000',
                'c00'
            ]
        ];
    }
}
