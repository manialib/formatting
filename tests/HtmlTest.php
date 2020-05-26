<?php

use Manialib\Formatting\Converter\Html;
use Manialib\Formatting\ManiaplanetString;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
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
            ],
            [
                'foo$<$f20bar',
                'foo<span style="color:#f20;">bar</span>'
            ],
            [
                '$l[http://maniaplanet.com]trackmania.com$l',
                '<a href="http://maniaplanet.com" style="color:inherit;">trackmania.com</a>'
            ],
            [
                '$lhttp://maniaplanet.com$l',
                '<a href="http://maniaplanet.com" style="color:inherit;">http://maniaplanet.com</a>'
            ],
            [
                '$l[www.clan-nuitblanche.org]$fff$l',
                '<a href="http://www.clan-nuitblanche.org" style="color:inherit;"></a>'
            ],
            [
                '$l[http://maniaplanet.com]foo$obar$l',
                '<a href="http://maniaplanet.com" style="color:inherit;">foo<span style="font-weight:bold;">bar</span></a>'
            ],
            [
                '$l[http://google.fr]google',
                '<a href="http://google.fr" style="color:inherit;">google</a>'
            ],
            [
                '$l[javascript:alert(1)]ahoy$l',
                '<a href="#" style="color:inherit;">ahoy</a>'
            ],
            [
                '$l["><script>alert(1)</script>]xss',
                '<a href="http://&quot;&gt;&lt;script&gt;alert(1)&lt;/script&gt;" style="color:inherit;">xss</a>'
            ],
            [
                '$l[http://example.org"><script>alert(1)</script>]xss2',
                '<a href="http://example.org&quot;&gt;&lt;script&gt;alert(1)&lt;/script&gt;" style="color:inherit;">xss2</a>'
            ],
            [
                '<script>alert(1)</script>',
                '&amp;lt;script&amp;gt;alert(1)&amp;lt;/script&amp;gt;',
            ],
            [
                'foo$zbar',
                'foobar'
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
