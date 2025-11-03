<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Blue,
    Intensity,
    Exception\InvalidValueRangeException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class BlueTest extends TestCase
{
    public function testInterface()
    {
        $blue = Blue::at(255);

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
        $blue = Blue::at(12)->add(Blue::at(30));

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(42, $blue->toInt());

        $this->assertSame(
            255,
            Blue::at(150)->add(Blue::at(150))->toInt(),
        );
    }

    public function testSub()
    {
        $blue = Blue::at(54)->subtract(Blue::at(12));

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(42, $blue->toInt());

        $this->assertSame(
            0,
            Blue::at(150)->subtract(Blue::at(255))->toInt(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-42');

        Blue::of(-42)->unwrap();
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('512');

        Blue::of(512)->unwrap();
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Blue::at(255)->atMaximum());
        $this->assertFalse(Blue::at(0)->atMaximum());
        $this->assertFalse(Blue::at(122)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Blue::at(255)->atMinimum());
        $this->assertTrue(Blue::at(0)->atMinimum());
        $this->assertFalse(Blue::at(122)->atMinimum());
    }

    public function testFromIntensity()
    {
        $blue = Blue::fromIntensity(Intensity::at(100))->match(
            static fn($blue) => $blue,
            static fn() => null,
        );

        $this->assertInstanceOf(Blue::class, $blue);
        $this->assertSame(255, $blue->toInt());
        $this->assertSame(
            191,
            Blue::fromIntensity(Intensity::at(75))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            128,
            Blue::fromIntensity(Intensity::at(50))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            64,
            Blue::fromIntensity(Intensity::at(25))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            0,
            Blue::fromIntensity(Intensity::at(0))->match(
                static fn($blue) => $blue->toInt(),
                static fn() => null,
            ),
        );
    }

    public function testEquals()
    {
        $this->assertTrue(Blue::at(50)->equals(Blue::at(50)));
        $this->assertFalse(Blue::at(100)->equals(Blue::at(50)));
    }
}
