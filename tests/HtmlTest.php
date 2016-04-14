<?php

use Manialib\Formatting\Converter\Html;
use Manialib\Formatting\ManialanetString;

class HtmlTest extends PHPUnit_Framework_TestCase
{

    public function convertProvider()
    {
        return [
            [
                '$cfeg$fff๐u1 $666ツ',
                '<span style="color:#cfe;">g</span><span style="color:#fff;">๐u1 </span><span style="color:#666;">ツ</span>'
            ],
            ['a$>b', 'ab']
        ];
    }

    /**
     * @dataProvider convertProvider
     */
    public function testConvert($input, $expected)
    {
        $this->assertEquals($expected, (new ManialanetString($input))->toHtml());
    }

    /**
     * @dataProvider convertProvider
     */
    public function testReuseConverter($input, $expected)
    {

        $converter = new Html();
        $this->assertEquals(
            $converter->setInput(new ManialanetString($input))->getOutput(),
            $converter->setInput(new ManialanetString($input))->getOutput());
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
        (new ManialanetString($input))->toHtml();
    }

}
