<?php
declare(strict_types = 1);

namespace Fixtures\Innmind\Colour;

use Innmind\Colour\{
    Colour as Colours,
    RGBA,
};
use Innmind\BlackBox\Set;

final class Colour
{
    /**
     * @return Set<RGBA>
     */
    public static function any(): Set
    {
        return Set\Decorate::immutable(
            static fn($case) => $case->toRGBA(),
            Set\Elements::of(...Colours::cases()),
        );
    }
}
