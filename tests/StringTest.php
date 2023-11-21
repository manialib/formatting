<?php

use Manialib\Formatting\ManiaplanetString;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    /**
     * @dataProvider toStringProvider
     */
    public function testToString($input, $expected)
    {
        $string = new ManiaplanetString($input);
        $this->assertSame($expected, $string->__toString());
    }

    public function toStringProvider()
    {
        return [
            ['test', 'test'],
            [null, '']
        ];
    }

    public function stripAllProvider()
    {
        return [
            ['$cfeg$fff๐u1 $666ツ', 'g๐u1 ツ'],
            ['$u$l[http://google.fr]google$l', 'google'],
            ['$17x$17x$17x$17x$17x$17x', 'xxxxxx'],
            ['$$0', '$0'],
            ['$fff$$000', '$000']
        ];
    }

    /**
     * @dataProvider stripAllProvider
     */
    public function testStripAll($input, $expected)
    {
        $this->assertEquals($expected, (new ManiaplanetString($input))->stripAll());
    }

    public function stripColorsProvider()
    {
        return [
            ['$f20x', 'x'],
            ['$17x$17x$17x$17x$17x$17x', 'xxxxxx'],
            ['$1x', 'x'],
            ['$fff$$000', '$000'],
        ];
    }

    /**
     * @dataProvider stripColorsProvider
     */
    public function testStripColors($input, $expected)
    {
        $this->assertEquals($expected, (new ManiaplanetString($input))->stripColors());
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
        $this->assertEquals($expected, (new ManiaplanetString($input))->stripLinks());
    }
}
