<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Red,
    Intensity,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RedTest extends TestCase
{
    public function testInterface()
    {
        $red = Red::at(255);

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
        $red = Red::at(12)->add(Red::at(30));

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(42, $red->toInt());

        $this->assertSame(
            255,
            Red::at(150)->add(Red::at(150))->toInt(),
        );
    }

    public function testSub()
    {
        $red = Red::at(54)->subtract(Red::at(12));

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(42, $red->toInt());

        $this->assertSame(
            0,
            Red::at(150)->subtract(Red::at(255))->toInt(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('-42');

        $_ = Red::of(-42)->unwrap();
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('512');

        $_ = Red::of(512)->unwrap();
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Red::at(255)->atMaximum());
        $this->assertFalse(Red::at(0)->atMaximum());
        $this->assertFalse(Red::at(122)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Red::at(255)->atMinimum());
        $this->assertTrue(Red::at(0)->atMinimum());
        $this->assertFalse(Red::at(122)->atMinimum());
    }

    public function testFromIntensity()
    {
        $red = Red::fromIntensity(Intensity::at(100))->match(
            static fn($red) => $red,
            static fn() => null,
        );

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(255, $red->toInt());
        $this->assertSame(
            191,
            Red::fromIntensity(Intensity::at(75))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            128,
            Red::fromIntensity(Intensity::at(50))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            64,
            Red::fromIntensity(Intensity::at(25))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
        $this->assertSame(
            0,
            Red::fromIntensity(Intensity::at(0))->match(
                static fn($red) => $red->toInt(),
                static fn() => null,
            ),
        );
    }

    public function testEquals()
    {
        $this->assertTrue(Red::at(50)->equals(Red::at(50)));
        $this->assertFalse(Red::at(100)->equals(Red::at(50)));
    }
}
