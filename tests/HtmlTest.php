<?php

use Manialib\Formatting\Converter\Html;
use Manialib\Formatting\String;

class HtmlTest extends PHPUnit_Framework_TestCase
{

    public function convertProvider()
    {
        return [
            [
                '$cfeg$fff๐u1 $666ツ',
                '<span style="color:#cfe;">g</span><span style="color:#fff;">๐u1 </span><span style="color:#666;">ツ</span>'
            ],
        ];
    }

    /**
     * @dataProvider convertProvider
     */
    public function testConvert($input, $expected)
    {
        $this->assertEquals($expected, (new String($input))->convert(new Html()));
    }

    /**
     * @dataProvider convertProvider
     */
    public function testReuseConverter($input, $expected)
    {

        $converter = new Html();
        $this->assertEquals((new String($input))->convert($converter), (new String($input))->convert($converter));
    }



}