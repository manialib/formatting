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
            ['$u$l[http://google.fr]google$l', 'google']
        ];
    }

    /**
     * @dataProvider stripAllProvider
     */
    public function testStripAll($input, $expected)
    {
        $this->assertEquals($expected, (new ManiaplanetString($input))->stripAll());
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
