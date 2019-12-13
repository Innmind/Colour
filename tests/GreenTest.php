<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Green,
    Intensity,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class GreenTest extends TestCase
{
    public function testInterface()
    {
        $green = new Green(255);

        $this->assertSame(255, $green->toInt());
        $this->assertSame('ff', (string) $green);
    }

    public function testFromHexadecimal()
    {
        $green = Green::fromHexadecimal('0f');

        $this->assertInstanceOf(Green::class, $green);
        $this->assertSame(15, $green->toInt());
        $this->assertSame('0f', (string) $green);
    }

    public function testAdd()
    {
        $Green = (new Green(12))->add(new Green(30));

        $this->assertInstanceOf(Green::class, $Green);
        $this->assertSame(42, $Green->toInt());

        $this->assertSame(
            255,
            (new Green(150))->add(new Green(150))->toInt()
        );
    }

    public function testSub()
    {
        $green = (new Green(54))->subtract(new Green(12));

        $this->assertInstanceOf(Green::class, $green);
        $this->assertSame(42, $green->toInt());

        $this->assertSame(
            0,
            (new Green(150))->subtract(new Green(255))->toInt()
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-42');

        new Green(-42);
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('512');

        new Green(512);
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Green(255))->atMaximum());
        $this->assertFalse((new Green(0))->atMaximum());
        $this->assertFalse((new Green(122))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Green(255))->atMinimum());
        $this->assertTrue((new Green(0))->atMinimum());
        $this->assertFalse((new Green(122))->atMinimum());
    }

    public function testFromIntensity()
    {
        $green = Green::fromIntensity(new Intensity(100));

        $this->assertInstanceOf(Green::class, $green);
        $this->assertSame(255, $green->toInt());
        $this->assertSame(
            191,
            Green::fromIntensity(new Intensity(75))->toInt()
        );
        $this->assertSame(
            128,
            Green::fromIntensity(new Intensity(50))->toInt()
        );
        $this->assertSame(
            64,
            Green::fromIntensity(new Intensity(25))->toInt()
        );
        $this->assertSame(
            0,
            Green::fromIntensity(new Intensity(0))->toInt()
        );
    }

    public function testEquals()
    {
        $this->assertTrue((new Green(50))->equals(new Green(50)));
        $this->assertFalse((new Green(100))->equals(new Green(50)));
    }
}
