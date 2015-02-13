# Manialib\Formatting

Manialib\Formatting is a PHP package for manipulating styles in Maniaplanet strings. 

Learn more about Maniaplanet formatting characters on the [wiki](http://wiki.maniaplanet.com/en/Profile#Nickname_customization).

## Beta

[![Build Status](https://img.shields.io/travis/manialib/formatting.svg?style=flat-square)](https://travis-ci.org/manialib/formatting)
[![Packagist Version](https://img.shields.io/packagist/v/manialib/formatting.svg?style=flat-square)](https://packagist.org/packages/manialib/formatting)
[![Total Downloads](https://img.shields.io/packagist/dt/manialib/formatting.svg?style=flat-square)](https://packagist.org/packages/manialib/formatting)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/ba2ace96-021c-4d69-8c03-3eff608c8a88.svg?style=flat-square)](https://insight.sensiolabs.com/projects/ba2ace96-021c-4d69-8c03-3eff608c8a88)

This is a work in progress. As long as we don't release a stable version, we might break stuff at any point. If this is a problem, feel free to open an issue and we'll try to help.

## Features

- Strip styles from strings: links, colors, etc.
- Convert strings to other formats: HTML for now

Find out more in the [change log](CHANGELOG.md).

## Requirements

- PHP 5.5+

## Installation

[Install via Composer](https://getcomposer.org/):

```json
{
	"require": {
        "manialib/formatting": "4.0.0-beta2"
    }
}
```

## Usage

Modify styles of a sring:

> Note the String fluent interface which allows to chain method calls

```php
use Manialib\Formatting\String;

$nickname = '$l[https://github.com/manialib/formatting]$cfeg$fff๐u1 $666ツ$l';

$string = new String($nickname);
echo $string->stripColors()->stripLinks();
```

Will output:

```
g๐u1 ツ
```

Convert a string to HTML:

```php
use Manialib\Formatting\String;;

$string = new String('$cfeg$fff๐u1 $666ツ');

echo $string->toHtml();
```

Will output:

```html
<span style="color:#cfe;">g</span><span style="color:#fff;">๐u1 </span><span style="color:#666;">ツ</span>
```

Everything you need for using this should be documented in [`Manialib/Formatting/StringInterface`](src/Manialib/Formatting/StringInterface.php).

## Tests

`$ php vendor/bin/phpunit`

`$ php vendor/bin/phpcs --standard=PSR2 src`

## Development guidelines

We follow best practices from the amazing PHP ecosystem. Warm kudos to [Symfony](http://symfony.com/), [The PHP League](http://thephpleague.com/), [the PHP subreddit](http://www.reddit.com/r/PHP/) and many more for inspiration and challenging ideas.

- We adhere to the best-practices put forward by [PHP The Right Way](http://www.phptherightway.com/)
- We comply to the standards of the [PHP-FIG](http://www.php-fig.org/)
- We distribute code via [Packagist](https://packagist.org/) and [Composer](https://getcomposer.org/)
- We manage version numbers with [Semantic Versioning](http://semver.org/)
- We [keep a changelog](http://keepachangelog.com/)
- We use `Manialib\` as our PHP vendor namespace
- We use `manialib/` as our Packagist vendor namespace
- We'll (try to) make documentation & tests :)
