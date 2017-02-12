<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Intensity;
use PHPUnit\Framework\TestCase;

class IntensityTest extends TestCase
{
    public function testInterface()
    {
        $intensity = new Intensity(42);

        $this->assertSame(42, $intensity->toInt());
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooLow()
    {
        new Intensity(-1);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooHigh()
    {
        new Intensity(101);
    }
}
