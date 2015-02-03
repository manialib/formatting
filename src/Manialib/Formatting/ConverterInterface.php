<?php

namespace Manialib\Formatting;

interface ConverterInterface
{

    /**
     * @return static
     */
    public function setInput(StringInterface $string);

    public function getOutput();
}
