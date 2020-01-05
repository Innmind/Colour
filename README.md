# Colour

| `develop` |
|-----------|
| [![codecov](https://codecov.io/gh/Innmind/Colour/branch/develop/graph/badge.svg)](https://codecov.io/gh/Innmind/Colour) |
| [![Build Status](https://github.com/Innmind/Colour/workflows/CI/badge.svg)](https://github.com/Innmind/Colour/actions?query=workflow%3ACI) |

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
* literals (as [defined](https://www.w3.org/wiki/CSS/Properties/color/keywords) by the W3C)

## Installation

```sh
composer install innmind/colour
```

## Usage

```php
use Innmind\Colour\Colour;

$rgba = Colour::of('39f');
$hsla = Colour::of('hsl(210, 100%, 60%)');
$cmyka = Colour::of('device-cmyk(80%, 40%, 0%, 0%)');
$rgba = Colour::of('blue');
```

Each representation can be represented to the other two so you can always work with your preferred format.
