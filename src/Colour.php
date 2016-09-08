<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidArgumentException;

final class Colour
{
    private function __construct()
    {
    }

    public static function fromString(string $colour): ConvertibleInterface
    {
        try {
            return RGBA::fromString($colour);
        } catch (InvalidArgumentException $e) {
            //attempt next format
        }

        try {
            return HSLA::fromString($colour);
        } catch (InvalidArgumentException $e) {
            //attempt next format
        }

        return CMYKA::fromString($colour);
    }
}
