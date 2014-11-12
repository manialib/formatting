<?php

namespace Manialib\Formatting;

interface ConverterInterface
{

    public function __construct($string);

    public function getResult();
}