<?php

namespace Manialib\Formatting;

abstract class Color
{
    const CONTRAST_DARKER  = -1;
    const CONTRAST_AUTO    = 0;
    const CONTRAST_LIGHTER = 1;

    public static function contrast($colorRgb, $backgroundRgb, $contrast = self::CONTRAST_AUTO)
    {
        $backgroundHsv = self::rgb24ToHsv($backgroundRgb);
        $colorHsv = self::rgb24ToHsv($colorRgb);
        $threshold = ($colorHsv['hue'] == $backgroundHsv['hue']) ? .05 : .025;

        if (self::difference($colorRgb, $backgroundRgb) > 20) {
            return $colorRgb;
        }
        if ($contrast === self::CONTRAST_AUTO) {
            if ($backgroundHsv['value'] < $threshold) {
                $contrast = self::CONTRAST_LIGHTER;
            } elseif ($backgroundHsv['saturation'] < $threshold) {
                $contrast = self::CONTRAST_DARKER;
            } elseif ($backgroundHsv['value'] < $colorHsv['value']) {
                $contrast = self::CONTRAST_LIGHTER;
            } elseif ($backgroundHsv['value'] > $colorHsv['value']) {
                $contrast = self::CONTRAST_DARKER;
            } elseif ($backgroundHsv['saturation'] > $colorHsv['saturation']) {
                $contrast = self::CONTRAST_LIGHTER;
            } elseif ($backgroundHsv['saturation'] < $colorHsv['saturation']) {
                $contrast = self::CONTRAST_DARKER;
            } elseif ($backgroundHsv['saturation'] < .5) {
                $contrast = self::CONTRAST_LIGHTER;
            } else {
                $contrast = self::CONTRAST_DARKER;
            }
        }

        $colorHsv['saturation'] -= $contrast * $threshold;
        $colorHsv['value'] += $contrast * $threshold;
        if ($colorHsv['saturation'] < 0) {
            $colorHsv['saturation'] = 0;
        } elseif ($colorHsv['saturation'] > 1) {
            $colorHsv['saturation'] = 1;
        }
        if ($colorHsv['value'] < 0) {
            $colorHsv['value'] = 0;
        } elseif ($colorHsv['value'] > 1) {
            $colorHsv['value'] = 1;
        }

        return self::hsvToRgb24($colorHsv);
    }

    private static function difference($rgb2, $rgb1)
    {
        $r = (($rgb2 & 0xff0000) >> 16) - (($rgb1 & 0xff0000) >> 16);
        $g = (($rgb2 & 0xff00) >> 8) - (($rgb1 & 0xff00) >> 8);
        $b = ($rgb2 & 0xff) - ($rgb1 & 0xff);

        return sqrt($r*$r + $g*$g + $b*$b);
    }

    /**
     * @param $hex string
     * @return int
     */
    public static function stringToRgb24($hex)
    {
        $hex = trim($hex, '#$');
        if (strlen($hex) == 3) {
            return self::rgb12ToRgb24(hexdec($hex) & 0xfff);
        } else {
            return hexdec($hex) & 0xffffff;
        }
    }

    /**
     * @param $hex string
     * @return int
     */
    public static function stringToRgb12($hex)
    {
        $hex = trim($hex, '#$');

        return hexdec($hex) & 0xfff;
    }

    /**
     * @param $rgb int
     * @return int
     */
    public static function rgb12ToRgb24($rgb)
    {
        return ($rgb & 0xf00) * 0x1100 + ($rgb & 0xf0) * 0x110 + ($rgb & 0xf) * 0x11;
    }

    /**
     * @param $rgb int
     * @return int
     */
    public static function rgb24ToRgb12($rgb)
    {
        $r = (int) round((($rgb & 0xff0000) >> 16) / 17);
        $g = (int) round((($rgb & 0xff00) >> 8) / 17);
        $b = (int) round(($rgb & 0xff) / 17);

        return ($r << 8) + ($g << 4) + $b;
    }

    /**
     * @param $rgb int
     * @return string
     */
    public static function rgb12ToString($rgb)
    {
        return str_pad(dechex($rgb), 3, '0', STR_PAD_LEFT);
    }

    public static function rgb24ToString($rgb)
    {
        $hex = str_pad(dechex($rgb), 6, '0', STR_PAD_LEFT);
        if (preg_match('/(?:([0-9a-z])\g{-1}){3}/i', $hex)) {
            return $hex[0].$hex[2].$hex[4];
        } else {
            return $hex;
        }
    }

    public static function rgb24ToHsv($rgb)
    {
        $r = (($rgb & 0xff0000) >> 16) / 255;
        $g = (($rgb & 0xff00) >> 8) / 255;
        $b = ($rgb & 0xff) / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $chroma = $max - $min;

        if ($chroma == 0) {
            $hue = 0;
        } elseif ($max == $r) {
            $hue = ($g - $b) / $chroma;
        } elseif ($max == $g) {
            $hue = (($b - $r) / $chroma) + 2;
        } else {
            $hue = (($r - $g) / $chroma) + 4;
        }

        return array('hue' => fmod($hue, 6),
                'saturation' => $max == 0 ? 0 : $chroma / $max,
                'value' => $max, );
    }

    public static function hsvToRgb24($hsv)
    {
        $hue = $hsv['hue'];
        $saturation = $hsv['saturation'];
        $value = $hsv['value'];

        $chroma = $saturation * $value;
        $x = $chroma * (1 - abs(fmod($hue, 2) - 1));

        if ($hue == 0) {
            $rgb = array(0, 0, 0);
        } elseif ($hue < 1) {
            $rgb = array($chroma, $x, 0);
        } elseif ($hue < 2) {
            $rgb = array($x, $chroma, 0);
        } elseif ($hue < 3) {
            $rgb = array(0, $chroma, $x);
        } elseif ($hue < 4) {
            $rgb = array(0, $x, $chroma);
        } elseif ($hue < 5) {
            $rgb = array($x, 0, $chroma);
        } elseif ($hue < 6) {
            $rgb = array($chroma, 0, $x);
        }

        $m = $value - $chroma;
        $r = intval(($rgb[0] + $m) * 255);
        $g = intval(($rgb[1] + $m) * 255);
        $b = intval(($rgb[2] + $m) * 255);

        return ($r << 16) + ($g << 8) + $b;
    }
}
