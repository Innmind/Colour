# Colour

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Colour/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Colour/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Colour/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Colour/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Colour/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Colour/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Colour/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Colour/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/Innmind/Colour/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Colour/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/Innmind/Colour/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Colour/build-status/develop) |

This library helps you build an object representation of a colour out of a string (all objects are immutable). You can easily extract any information out of the colors, transform their representation and modify the colours.

It supports these formats:

    * `#39f`
    * `#39ff` (last hexadecimal value for the alpha)
    * `#3399ff`
    * `#3399ffff` (last 2 hexadecimal values for the alpha)
    * `rgb()`
    * `rgba()`
    * `hsl()`
    * `hsla()`
    * `device-cmyk()`
    * literals (as [defined](http://www.w3schools.com/colors/colors_names.asp) by the W3C)

## Installation

```sh
composer install innmind/colour
```

## Usage

```php
use Innmind\Colour\Colour;

$rgba = Colour::fromString('39f');
$hsla = Colour::fromString('hsl(210, 100%, 60%)');
$cmyka = Colour::fromString('device-cmyk(80%, 40%, 0%, 0%)');
$rgba = Colour::fromString('blue');
```

Each representation can be represented to the other two so you can always work with your preferred format.
