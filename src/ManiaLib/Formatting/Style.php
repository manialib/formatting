<?php

namespace Manialib\Formatting;

class Style
{
    protected $bold = false;
    protected $italic = false;
    protected $shadowed = false;
    protected $width = 1;
    protected $uppercase = false;
    protected $color;

    public function isBold()
    {
        return $this->bold;
    }

    public function isItalic()
    {
        return $this->italic;
    }

    public function isShadowed()
    {
        return $this->shadowed;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function isUppercase()
    {
        return $this->uppercase;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setBold($bold)
    {
        $this->bold = $bold;
    }

    public function setItalic($italic)
    {
        $this->italic = $italic;
    }

    public function setShadowed($shadowed)
    {
        $this->shadowed = $shadowed;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setUppercase($uppercase)
    {
        $this->uppercase = $uppercase;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }
}