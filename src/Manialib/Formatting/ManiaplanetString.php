<?php

namespace Manialib\Formatting;

use Manialib\Formatting\Converter\Html;

/**
 * @api
 */
class ManiaplanetString implements StringInterface
{
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function __toString()
    {
        return (string) $this->string;
    }

    public function contrastColors($backgroundColor)
    {
        $background = Color::stringToRgb24($backgroundColor);
        $this->string = preg_replace_callback(
            '/(?<!\$)((?:\$[\$])*)(\$[0-9a-f][^\$]{0,2})/iu',
            function ($matches) use ($background) {
                $color = Color::stringToRgb24($matches[2]);
                $color = Color::contrast($color, $background);
                $color = Color::rgb24ToRgb12($color);
                $color = Color::rgb12ToString($color);

                return $matches[1].'$'.$color;
            },
            $this->string
        );

        return $this;
    }

    public function strip($codes)
    {
        $linkCodes = array();
        preg_match_all('/[hlp]/iu', $codes, $linkCodes);
        $colorCodes = array();
        preg_match_all('/[0-9a-f]/iu', $codes, $colorCodes);
        $escapedChars = array();
        preg_match_all('/[\$\[\]]/iu', $codes, $escapedChars);

        if (count($linkCodes[0])) {
            $this->string = (string) $this->doStripLinks(array_unique($linkCodes[0]));
        }
        if (count($colorCodes[0])) {
            $this->string = (string) $this->stripColors();
        }
        $pattern = sprintf('/(?<!\$)((?:\$[\$\[\]])*)\$[%s]/iu', $codes);
        $this->string = preg_replace($pattern, '$1', $this->string);
        if (count($escapedChars[0])) {
            $this->string = (string) $this->doStripEscapedCharacters(array_unique($escapedChars[0]));
        }

        return $this;
    }

    public function stripAll()
    {
        $this->string = preg_replace('/(?<!\$)((?:\$\$)*)\$[^$0-9a-fhlp\[\]]/iu', '$1', $this->string);

        return $this->stripEscapeCharacters()->stripLinks()->stripColors();
    }

    public function stripColors()
    {
        $this->string = preg_replace('/(?<!\$)((?:\$\$)*)\$(?:[0-9a-f]{0,3})/iu', '$1', $this->string);

        return $this;
    }

    public function stripLinks()
    {
        return $this->doStripLinks();
    }

    public function stripEscapeCharacters()
    {
        return $this->doStripEscapedCharacters();
    }

    public function toHtml()
    {
        return (new Html())->setInput($this)->getOutput();
    }

    protected function doStripLinks(array $codes = array('h', 'l', 'p'))
    {
        $pattern = sprintf(
            '/(?<!\$)((?:\$\$)*)\$[%s](?:\[.*?\]|\[.*?$)?(.*?)(?:\$[%1$s]|(\$z)|$)/iu',
            implode('', $codes)
        );
        $this->string = preg_replace($pattern, '$1$2$3', $this->string);

        return $this;
    }

    protected function doStripEscapedCharacters(array $codes = array('$', '[', ']'))
    {
        $pattern = sprintf('/\$([%s])/iu', addcslashes(implode('', $codes), '$[]'));
        $this->string = preg_replace($pattern, '$1', $this->string);

        return $this;
    }
}
