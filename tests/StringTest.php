<?php

use Manialib\Formatting\ManialanetString;

class StringTest extends PHPUnit_Framework_TestCase
{

    public function stripAllProvider()
    {
        return [
            ['$cfeg$fff๐u1 $666ツ', 'g๐u1 ツ'],
        ];
    }

    /**
     * @dataProvider stripAllProvider
     */
    public function testStripAll($input, $expected)
    {
        $this->assertEquals($expected, (new ManialanetString($input))->stripAll());
    }

    public function stripLinksProvider()
    {
        return [
            ['$ltest$l', 'test'],
            ['$l[link]test$l', 'test'],
            ['$htest$h', 'test'],
            ['$h[link]test$h', 'test'],
        ];
    }

    /**
     * @dataProvider stripLinksProvider
     */
    public function testStripLinks($input, $expected)
    {
        $this->assertEquals($expected, (new ManialanetString($input))->stripLinks());
    }


}
