<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour\Fixtures;

use Fixtures\Innmind\Colour\Colour;
use Innmind\Colour\RGBA;
use Innmind\BlackBox\{
    PHPUnit\Framework\TestCase,
    Set,
    Random,
};

class ColourTest extends TestCase
{
    public function testInterface()
    {
        $set = Colour::any()->take(100);

        $this->assertInstanceOf(Set::class, $set);

        foreach ($set->values(Random::default) as $value) {
            $this->assertInstanceOf(Set\Value::class, $value);
            $this->assertInstanceOf(RGBA::class, $value->unwrap());
        }
    }
}
