<?php

declare(strict_types=1);

namespace Manialib\Formatting;

use Manialib\Formatting\Converter\Strip;

class Stripper
{
    public function stripAll(string $value): string
    {
        return (new Strip())->setInput($value)->getOutput();
    }
}
