<?php

namespace Manialib\Formatting\Converter;

use Manialib\Formatting\Color;
use Manialib\Formatting\Parser;

class Html extends Parser
{
    protected $link = null;

    protected function none($value)
    {
        $style = '';
        if ($this->currentStyle->getColor()) {
            $color = Color::stringToRgb24($this->currentStyle->getColor());
            $style .= sprintf('color:#%s;', Color::rgb24ToString($color));
        }
        switch ($this->currentStyle->getWidth()) {
            case 0:
                $style .= 'letter-spacing:-.1em;font-size:95%;';
                break;
            case 2:
                $style .= 'letter-spacing:.1em;font-size:105%;';
                break;
            case 1:
            default:
        }
        if ($this->currentStyle->isBold()) {
            $style .= 'font-weight:bold;';
        }
        if ($this->currentStyle->isItalic()) {
            $style .= 'font-style:italic;';
        }
        if ($this->currentStyle->isShadowed()) {
            $style .= 'text-shadow:1px 1px 1px rgba(0,0,0,.5);';
        }
        if ($this->currentStyle->isUppercase()) {
            $style .= 'text-transform:uppercase;';
        }
        if ($style) {
            $value = sprintf('<span style="%s">%s</span>', $style, $value);
        }
        $this->result .= $value;
    }

    protected function escapedCharacter($value)
    {
        $this->none($value);
    }

    protected function color()
    {
    }

    protected function shadowed()
    {
    }

    protected function bold()
    {
    }

    protected function italic()
    {
    }

    protected function wide()
    {
    }

    protected function narrow()
    {
    }

    protected function medium()
    {
    }

    protected function upperCase()
    {
    }

    protected function resetAll()
    {
        $this->closeLink();
    }

    protected function pushStyle()
    {
    }

    protected function popStyle()
    {
    }

    protected function openExternalLink($link)
    {
        $this->openLink($link);
    }

    protected function closeExternalLink()
    {
        $this->closeLink();
    }

    protected function openInternalLink($link)
    {
        $protocol = 'maniaplanet://';
        if (substr($link, 0, strlen($protocol)) != $protocol) {
            $link = sprintf('maniaplanet:///:%s', $link);
        }
        $this->openLink($link);
    }

    private function openLink($link)
    {
        $this->result .= sprintf('<a href="%s" style="color:inherit;">', $link);
    }

    protected function closeInternalLink()
    {
        $this->closeLink();
    }

    protected function closeLink()
    {
        $this->result .= '</a>';
    }

    protected function secureInternalLink($link)
    {
        return $link;
    }
}
