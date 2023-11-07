<?php

namespace Manialib\Formatting\Converter;

use Manialib\Formatting\Color;
use Manialib\Formatting\Parser;

class Strip extends Parser
{
    protected $link = null;

    protected function none($value)
    {
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
        $scheme = parse_url($link, PHP_URL_SCHEME);
        if ($scheme === null) {
            $scheme = 'http';
            $link = 'http://'.$link;
        }
        if (!in_array($scheme, ['http', 'https', 'maniaplanet'])) {
            $link = '#';
        }
        $this->result .= sprintf('<a href="%s" style="color:inherit;">', htmlspecialchars($link));
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
