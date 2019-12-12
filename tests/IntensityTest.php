<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Intensity,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class IntensityTest extends TestCase
{
    public function testInterface()
    {
        $intensity = new Intensity(42);

        $this->assertSame(42, $intensity->toInt());
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Intensity(-1);
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Intensity(101);
    }
}
