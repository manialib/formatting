<?php

namespace Manialib\Formatting;

/**
 * @api
 */
interface StringInterface
{
    public function __construct($string);

    /**
     * @param  string $codes
     * @return static
     */
    public function strip($codes);

    /**
     * @param  string $codes
     * @return static
     */
    public function stripAll();

    /**
     * @return static
     */
    public function stripLinks();

    /**
     * @return static
     */
    public function stripColors();

    /**
     * @return static
     */
    public function stripEscapeCharacters();

    /**
     * @param  string $backgroundColor
     * @return static
     */
    public function contrastColors($backgroundColor);

    /**
     * @return string
     */
    public function toHtml();

    /**
     * @return string
     */
    public function __toString();
}
