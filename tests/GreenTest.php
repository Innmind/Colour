<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Green,
    Intensity,
    Exception\InvalidValueRangeException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class GreenTest extends TestCase
{
    public function testInterface()
    {
        $green = Green::at(255);

        $this->assertSame(255, $green->toInt());
        $this->assertSame('ff', $green->toString());
    }

    public function testFromHexadecimal()
    {
        $green = Green::fromHexadecimal('0f')->match(
            static fn($green) => $green,
            static fn() => null,
        );

        $this->assertInstanceOf(Green::class, $green);
        $this->assertSame(15, $green->toInt());
        $this->assertSame('0f', $green->toString());
    }

    public function testAdd()
    {
        $Green = Green::at(12)->add(Green::at(30));

        $this->assertInstanceOf(Green::class, $Green);
        $this->assertSame(42, $Green->toInt());

        $this->assertSame(
            255,
            Green::at(150)->add(Green::at(150))->toInt(),
        );
    }

    public function testSub()
    {
        $green = Green::at(54)->subtract(Green::at(12));

        $this->assertInstanceOf(Green::class, $green);
        $this->assertSame(42, $green->toInt());

        $this->assertSame(
            0,
            Green::at(150)->subtract(Green::at(255))->toInt(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-42');

        Green::of(-42)->unwrap();
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('512');

        Green::of(512)->unwrap();
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Green::at(255)->atMaximum());
        $this->assertFalse(Green::at(0)->atMaximum());
        $this->assertFalse(Green::at(122)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Green::at(255)->atMinimum());
        $this->assertTrue(Green::at(0)->atMinimum());
        $this->assertFalse(Green::at(122)->atMinimum());
    }

    public function testFromIntensity()
    {
        $green = Green::fromIntensity(Intensity::at(100))->match(
            static fn($green) => $green,
            static fn() => null,
        );

        $this->assertInstanceOf(Green::class, $green);
        $this->assertSame(255, $green->toInt());
        $this->assertSame(
            191,
            Green::fromIntensity(Intensity::at(75))->match(
                static fn($green) => $green->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            128,
            Green::fromIntensity(Intensity::at(50))->match(
                static fn($green) => $green->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            64,
            Green::fromIntensity(Intensity::at(25))->match(
                static fn($green) => $green->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            0,
            Green::fromIntensity(Intensity::at(0))->match(
                static fn($green) => $green->toInt(),
                static fn() => null,
            ),
        );
    }

    public function testEquals()
    {
        $this->assertTrue(Green::at(50)->equals(Green::at(50)));
        $this->assertFalse(Green::at(100)->equals(Green::at(50)));
    }
}
