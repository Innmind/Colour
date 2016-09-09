<?php
declare(strict_types = 1);

namespace Innmind\Colour;

interface ConvertibleInterface
{
    public function toRGBA(): RGBA;
    public function toHSLA(): HSLA;
    public function toCMYKA(): CMYKA;
}
