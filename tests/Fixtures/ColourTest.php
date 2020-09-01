<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour\Fixtures;

use Fixtures\Innmind\Colour\Colour;
use Innmind\Colour\RGBA;
use Innmind\BlackBox\Set;
use Innmind\BlackBox\Random;
use PHPUnit\Framework\TestCase;

class ColourTest extends TestCase implements Random
{
    public function testInterface()
    {
        $set = Colour::any();

        $this->assertInstanceOf(Set::class, $set);

        foreach ($set->values(new self) as $value) {
            $this->assertInstanceOf(Set\Value::class, $value);
            $this->assertTrue($value->isImmutable());
            $this->assertInstanceOf(RGBA::class, $value->unwrap());
        }
    }

    public function __invoke(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}
