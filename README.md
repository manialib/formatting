# Manialib\Formatting

A simple PHP component for manipulating styles in [Maniaplanet](http://manaplanet.com) strings. 

## Work in progress

This is a work in progress. Don't except stability, backwards compatibility, or anything like this until 4.0 is release. 
If you want to work with this, feel free to open an issue to ask for a release. 

## Features

- Strip styles from strings: links, colors, etc.
- Convert strings to other formats: HTML converter provided.

## Requirements

- PHP 5.5+

## Installation

[Install via Composer](https://getcomposer.org/):

```json
{
	"require": {
        "manialib/formatting": "4.0.*@dev"
    }
}
```

## Usage

Modify styles of a sring:

```php
use Manialib\Formatting\String;

$nickname = '$l[https://github.com/manialib/formatting]$cfeg$fff๐u1 $666ツ$l';

$string = new String($originalString);
echo $string->stripColors()->stripLinks();
```

Will output:

```
g๐u1 ツ
```

Convert a string to HTML:

```php
use Manialib\Formatting\Converters\Html;

$nickname = '$cfeg$fff๐u1 $666ツ';

$converter = new Html($nickname);
echo $converter->getResult();
```

Will output:

```html
<span style="color:#cfe;">g</span><span style="color:#fff;">๐u1 </span><span style="color:#666;">ツ</span>
```

## Run tests

`php vendor/bin/phpunit`

## TODO

[] Write more tests
[] Image converter

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