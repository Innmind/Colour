<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Blue,
    Intensity
};
use PHPUnit\Framework\TestCase;

class BlueTest extends TestCase
{
    public function testInterface()
    {
        $blue = new Blue(255);

        $this->assertSame(255, $blue->toInt());
        $this->assertSame('ff', (string) $blue);
    }

    public function testFromHexadecimal()
    {
        $blue = Blue::fromHexadecimal('0f');

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(15, $blue->toInt());
        $this->assertSame('0f', (string) $blue);
    }

    public function testAdd()
    {
        $blue = (new Blue(12))->add(new Blue(30));

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(42, $blue->toInt());

        $this->assertSame(
            255,
            (new Blue(150))->add(new Blue(150))->toInt()
        );
    }

    public function testSub()
    {
        $blue = (new Blue(54))->subtract(new Blue(12));

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(42, $blue->toInt());

        $this->assertSame(
            0,
            (new Blue(150))->subtract(new Blue(255))->toInt()
        );
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooLow()
    {
        new Blue(-42);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooHigh()
    {
        new Blue(512);
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Blue(255))->atMaximum());
        $this->assertFalse((new Blue(0))->atMaximum());
        $this->assertFalse((new Blue(122))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Blue(255))->atMinimum());
        $this->assertTrue((new Blue(0))->atMinimum());
        $this->assertFalse((new Blue(122))->atMinimum());
    }

    public function testFromIntensity()
    {
        $blue = Blue::fromIntensity(new Intensity(100));

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(255, $blue->toInt());
        $this->assertSame(
            191,
            Blue::fromIntensity(new Intensity(75))->toInt()
        );
        $this->assertSame(
            128,
            Blue::fromIntensity(new Intensity(50))->toInt()
        );
        $this->assertSame(
            64,
            Blue::fromIntensity(new Intensity(25))->toInt()
        );
        $this->assertSame(
            0,
            Blue::fromIntensity(new Intensity(0))->toInt()
        );
    }

    public function testEquals()
    {
        $this->assertTrue((new Blue(50))->equals(new Blue(50)));
        $this->assertFalse((new Blue(100))->equals(new Blue(50)));
    }
}
