<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Blue,
    Intensity,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class BlueTest extends TestCase
{
    public function testInterface()
    {
        $blue = new Blue(255);

        $this->assertSame(255, $blue->toInt());
        $this->assertSame('ff', $blue->toString());
    }

    public function testFromHexadecimal()
    {
        $blue = Blue::fromHexadecimal('0f')->match(
            static fn($blue) => $blue,
            static fn() => null,
        );

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(15, $blue->toInt());
        $this->assertSame('0f', $blue->toString());
    }

    public function testAdd()
    {
        $blue = (new Blue(12))->add(new Blue(30));

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(42, $blue->toInt());

        $this->assertSame(
            255,
            (new Blue(150))->add(new Blue(150))->toInt(),
        );
    }

    public function testSub()
    {
        $blue = (new Blue(54))->subtract(new Blue(12));

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(42, $blue->toInt());

        $this->assertSame(
            0,
            (new Blue(150))->subtract(new Blue(255))->toInt(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-42');

        new Blue(-42);
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('512');

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
        $blue = Blue::fromIntensity(new Intensity(100))->match(
            static fn($blue) => $blue,
            static fn() => null,
        );

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(255, $blue->toInt());
        $this->assertSame(
            191,
            Blue::fromIntensity(new Intensity(75))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            128,
            Blue::fromIntensity(new Intensity(50))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            64,
            Blue::fromIntensity(new Intensity(25))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            0,
            Blue::fromIntensity(new Intensity(0))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
    }

    public function testEquals()
    {
        $this->assertTrue((new Blue(50))->equals(new Blue(50)));
        $this->assertFalse((new Blue(100))->equals(new Blue(50)));
    }
}
