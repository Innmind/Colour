<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Lightness;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LightnessTest extends TestCase
{
    public function testInterface()
    {
        $lightness = Lightness::at(100);

        $this->assertSame(100, $lightness->toInt());
        $this->assertSame('100', $lightness->toString());
    }

    public function testAdd()
    {
        $lightness = Lightness::at(12)->add(Lightness::at(30));

        $this->assertInstanceOf(Lightness::class, $lightness);
        $this->assertSame(42, $lightness->toInt());

        $this->assertSame(
            100,
            Lightness::at(50)->add(Lightness::at(75))->toInt(),
        );
    }

    public function testSub()
    {
        $lightness = Lightness::at(54)->subtract(Lightness::at(12));

        $this->assertInstanceOf(Lightness::class, $lightness);
        $this->assertSame(42, $lightness->toInt());

        $this->assertSame(
            0,
            Lightness::at(50)->subtract(Lightness::at(75))->toInt(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('-42');

        $_ = Lightness::of(-42)->unwrap();
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('101');

        $_ = Lightness::of(101)->unwrap();
    }

    public function testEquals()
    {
        $this->assertTrue(Lightness::at(50)->equals(Lightness::at(50)));
        $this->assertFalse(Lightness::at(100)->equals(Lightness::at(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Lightness::at(100)->atMaximum());
        $this->assertFalse(Lightness::at(0)->atMaximum());
        $this->assertFalse(Lightness::at(50)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Lightness::at(100)->atMinimum());
        $this->assertTrue(Lightness::at(0)->atMinimum());
        $this->assertFalse(Lightness::at(50)->atMinimum());
    }
}
