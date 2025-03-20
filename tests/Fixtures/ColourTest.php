<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour\Fixtures;

use Fixtures\Innmind\Colour\Colour;
use Innmind\Colour\RGBA;
use Innmind\BlackBox\{
    Set,
    Random,
};
use PHPUnit\Framework\TestCase;

class ColourTest extends TestCase
{
    public function testInterface()
    {
        $set = Colour::any();

        $this->assertInstanceOf(Set::class, $set);

        foreach ($set->values(Random::default) as $value) {
            $this->assertInstanceOf(Set\Value::class, $value);

            if (\interface_exists(Set\Implementation::class)) {
                $this->assertTrue($value->immutable());
            } else {
                $this->assertTrue($value->isImmutable());
            }

            $this->assertInstanceOf(RGBA::class, $value->unwrap());
        }
    }
}
