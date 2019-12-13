<?php
declare(strict_types = 1);

namespace Fixtures\Innmind\Colour;

use Innmind\Colour\{
    Colour as Colours,
    RGBA,
};
use Innmind\BlackBox\Set;
use function Innmind\Immutable\unwrap;

final class Colour
{
    /**
     * @return Set<RGBA>
     */
    public static function any(): Set
    {
        return Set\Elements::of(
            ...unwrap(Colours::literals()->values()),
        );
    }
}
