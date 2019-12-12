<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Lightness,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class LightnessTest extends TestCase
{
    public function testInterface()
    {
        $lightness = new Lightness(100);

        $this->assertSame(100, $lightness->toInt());
        $this->assertSame('100', (string) $lightness);
    }

    public function testAdd()
    {
        $lightness = (new Lightness(12))->add(new Lightness(30));

        $this->assertInstanceOf(Lightness::class, $lightness);
        $this->assertSame(42, $lightness->toInt());

        $this->assertSame(
            100,
            (new Lightness(50))->add(new Lightness(75))->toInt()
        );
    }

    public function testSub()
    {
        $lightness = (new Lightness(54))->subtract(new Lightness(12));

        $this->assertInstanceOf(Lightness::class, $lightness);
        $this->assertSame(42, $lightness->toInt());

        $this->assertSame(
            0,
            (new Lightness(50))->subtract(new Lightness(75))->toInt()
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Lightness(-42);
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Lightness(101);
    }

    public function testEquals()
    {
        $this->assertTrue((new Lightness(50))->equals(new Lightness(50)));
        $this->assertFalse((new Lightness(100))->equals(new Lightness(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Lightness(100))->atMaximum());
        $this->assertFalse((new Lightness(0))->atMaximum());
        $this->assertFalse((new Lightness(50))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Lightness(100))->atMinimum());
        $this->assertTrue((new Lightness(0))->atMinimum());
        $this->assertFalse((new Lightness(50))->atMinimum());
    }
}
