<?php

namespace Manialib\Formatting;

abstract class Parser implements ConverterInterface
{
    /**
     * @var Lexer
     */
    protected $lexer;

    /**
     * @var array
     */
    protected $stylesStack;

    /**
     * @var Style
     */
    protected $currentStyle;

    /**
     * @var bool
     */
    protected $isInLink;

    /**
     * @var string
     */
    protected $result;

    /**
     * @var array
     */
    protected $lookaheadToSkip;

    public function __construct()
    {
        $this->lexer = new Lexer();
        $this->init();
    }

    public function setInput(StringInterface $string)
    {
        $this->init();
        $this->lexer->setInput((string) $string);

        return $this;
    }

    private function init()
    {
        $this->stylesStack = [];
        $this->currentStyle = new Style();
        $this->isInLink = false;
        $this->result = '';
        $this->lookaheadToSkip = [];
    }

    public function getOutput()
    {
        if (!$this->result) {
            $this->parseString();
        }

        return $this->result;
    }

    protected function parseString()
    {
        while ($this->lexer->moveNext()) {
            if (in_array($this->lexer->lookahead, $this->lookaheadToSkip)) {
                continue;
            }

            $value = $this->lexer->lookahead['value'];
            switch ($this->lexer->lookahead['type']) {
                case Lexer::T_NONE:
                    $this->none(htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
                    break;
                case Lexer::T_ESCAPED_CHAR:
                    $this->escapedCharacter($value);
                    break;
                case Lexer::T_COLOR:
                    $color = preg_replace('/([^0-9a-f])/iu', '0', $value);
                    $this->currentStyle->setColor($color);
                    $this->color();
                    break;
                case Lexer::T_NO_COLOR:
                    if ($this->stylesStack) {
                        $color = $this->stylesStack[count($this->stylesStack) - 1]->getColor();
                    } else {
                        $color = null;
                    }
                    $this->currentStyle->setColor($color);
                    $this->color();
                    break;
                case Lexer::T_SHADOWED:
                    $this->currentStyle->setShadowed(!$this->currentStyle->isShadowed());
                    $this->shadowed();
                    break;
                case Lexer::T_BOLD:
                    $this->currentStyle->setBold(!$this->currentStyle->isBold());
                    $this->bold();
                    break;
                case Lexer::T_ITALIC:
                    $this->currentStyle->setItalic(!$this->currentStyle->isItalic());
                    $this->italic();
                    break;
                case Lexer::T_WIDE:
                    $this->currentStyle->setWidth(2);
                    $this->wide();
                    break;
                case Lexer::T_NARROW:
                    $this->currentStyle->setWidth(0);
                    $this->narrow();
                    break;
                case Lexer::T_MEDIUM:
                    $this->currentStyle->setWidth(1);
                    $this->medium();
                    break;
                case Lexer::T_UPPERCASE:
                    $this->currentStyle->setUppercase(!$this->currentStyle->isUppercase());
                    $this->upperCase();
                    break;
                case Lexer::T_RESET_ALL:
                    if ($this->stylesStack) {
                        $style = $this->stylesStack[count($this->stylesStack) - 1];
                    } else {
                        $style = new Style();
                    }
                    $this->currentStyle = $style;
                    if ($this->isInLink) {
                        $this->closeExternalLink();
                    }
                    $this->isInLink = false;
                    break;
                case Lexer::T_PUSH:
                    array_push($this->stylesStack, $this->currentStyle);
                    $this->currentStyle = clone $this->currentStyle;
                    $this->pushStyle();
                    break;
                case Lexer::T_POP:
                    if (count($this->stylesStack)) {
                        $this->currentStyle = array_pop($this->stylesStack);
                    }
                    $this->popStyle();
                    break;
                case Lexer::T_EXTERNAL_LINK:
                    $this->isInLink = !$this->isInLink;
                    if ($this->isInLink) {
                        $link = $this->getLink();
                        $this->openExternalLink($link);
                    } else {
                        $this->closeExternalLink();
                    }
                    break;
                case Lexer::T_INTERNAL_LINK:
                    $this->isInLink = !$this->isInLink;
                    if ($this->isInLink) {
                        $link = $this->getLink();
                        $this->openInternalLink($link);
                    } else {
                        $this->closeInternalLink();
                    }
                    break;
                case Lexer::T_UNKNOWN_MARKUP:
                    // We do nothing with unknown markup for the moment
                    break;
            }
        }
        if ($this->isInLink) {
            $this->closeInternalLink();
        }
    }

    private function getLink()
    {
        $link = '';
        if (substr($this->lexer->lookahead['value'], 1, 1) == '['
            && substr($this->lexer->lookahead['value'], -1, 1) == ']'
        ) {
            //We are looking for a link like $h[xxx]yyy$h
            $this->lexer->moveNext();
            $matches = array();
            if ($this->lexer->lookahead
                && preg_match('/^\[([^\]]*)\]$/iu', $this->lexer->lookahead['value'], $matches)
            ) {
                $link = $matches[1];
            }
        } else {
            //We are looking for a link like $hxxxx$h
            $endLinkTokens = array(
                Lexer::T_EXTERNAL_LINK,
                Lexer::T_INTERNAL_LINK,
                Lexer::T_RESET_ALL,
            );
            do {
                $nextLookahead = $this->lexer->peek();
                if ($nextLookahead
                    && ($nextLookahead['type'] == Lexer::T_NONE || $nextLookahead['type'] == Lexer::T_ESCAPED_CHAR)
                ) {
                    $link .= $nextLookahead['value'];
                    if (substr($link, 0, 1) == '[') {
                        //It means that there is no closing square bracket $l[noclosingsquarebracket
                        array_push($this->lookaheadToSkip, $nextLookahead);
                    }
                }
            } while ($nextLookahead !== null && !in_array($nextLookahead['type'], $endLinkTokens));

            if (substr($link, 0, 1) == '[') {
                //It means that there is no closing square bracket $l[noclosingsquarebracket
                $link = '';
            }
        }

        return $link;
    }

    abstract protected function none($value);

    abstract protected function escapedCharacter($value);

    abstract protected function color();

    abstract protected function shadowed();

    abstract protected function bold();

    abstract protected function italic();

    abstract protected function wide();

    abstract protected function narrow();

    abstract protected function medium();

    abstract protected function upperCase();

    abstract protected function resetAll();

    abstract protected function pushStyle();

    abstract protected function popStyle();

    abstract protected function openExternalLink($link);

    abstract protected function closeExternalLink();

    abstract protected function openInternalLink($link);

    abstract protected function closeInternalLink();
}
