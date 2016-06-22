<?php

use Manialib\Formatting\Converter\Html;
use Manialib\Formatting\ManiaplanetString;

class HtmlTest extends PHPUnit_Framework_TestCase
{

    public function convertProvider()
    {
        return [
            [
                '$cfeg$fff๐u1 $666ツ',
                '<span style="color:#cfe;">g</span><span style="color:#fff;">๐u1 </span><span style="color:#666;">ツ</span>'
            ],
            [
                'a$>b',
                'ab'
            ],
            [
                'foo$<$f20foo$>bar',
                'foo<span style="color:#f20;">foo</span>bar'
            ]
        ];
    }

    /**
     * @dataProvider convertProvider
     */
    public function testConvert($input, $expected)
    {
        $this->assertEquals($expected, (new ManiaplanetString($input))->toHtml());
    }

    /**
     * @dataProvider convertProvider
     */
    public function testReuseConverter($input, $expected)
    {

        $converter = new Html();
        $this->assertEquals(
            $converter->setInput(new ManiaplanetString($input))->getOutput(),
            $converter->setInput(new ManiaplanetString($input))->getOutput());
    }

    public function nicknamesProvider()
    {
        return [
            ['']
        ];
    }

    /**
     * @dataProvider nicknamesProvider
     */
    public function testNoErrors($input)
    {
        (new ManiaplanetString($input))->toHtml();
    }

}
