<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Red,
    Intensity,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class RedTest extends TestCase
{
    public function testInterface()
    {
        $red = new Red(255);

        $this->assertSame(255, $red->toInt());
        $this->assertSame('ff', $red->toString());
    }

    public function testFromHexadecimal()
    {
        $red = Red::fromHexadecimal('0f')->match(
            static fn($red) => $red,
            static fn() => null,
        );

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(15, $red->toInt());
        $this->assertSame('0f', $red->toString());
    }

    public function testAdd()
    {
        $red = (new Red(12))->add(new Red(30));

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(42, $red->toInt());

        $this->assertSame(
            255,
            (new Red(150))->add(new Red(150))->toInt()
        );
    }

    public function testSub()
    {
        $red = (new Red(54))->subtract(new Red(12));

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(42, $red->toInt());

        $this->assertSame(
            0,
            (new Red(150))->subtract(new Red(255))->toInt()
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-42');

        new Red(-42);
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('512');

        new Red(512);
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Red(255))->atMaximum());
        $this->assertFalse((new Red(0))->atMaximum());
        $this->assertFalse((new Red(122))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Red(255))->atMinimum());
        $this->assertTrue((new Red(0))->atMinimum());
        $this->assertFalse((new Red(122))->atMinimum());
    }

    public function testFromIntensity()
    {
        $red = Red::fromIntensity(new Intensity(100))->match(
            static fn($red) => $red,
            static fn() => null,
        );

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(255, $red->toInt());
        $this->assertSame(
            191,
            Red::fromIntensity(new Intensity(75))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            128,
            Red::fromIntensity(new Intensity(50))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            64,
            Red::fromIntensity(new Intensity(25))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            0,
            Red::fromIntensity(new Intensity(0))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
    }

    public function testEquals()
    {
        $this->assertTrue((new Red(50))->equals(new Red(50)));
        $this->assertFalse((new Red(100))->equals(new Red(50)));
    }
}
