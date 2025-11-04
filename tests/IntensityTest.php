<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Intensity;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IntensityTest extends TestCase
{
    public function testInterface()
    {
        $intensity = Intensity::at(42);

        $this->assertSame(42, $intensity->toInt());
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('-1');

        Intensity::of(-1)->unwrap();
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('101');

        Intensity::of(101)->unwrap();
    }
}
