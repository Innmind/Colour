<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Saturation,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class SaturationTest extends TestCase
{
    public function testInterface()
    {
        $saturation = new Saturation(100);

        $this->assertSame(100, $saturation->toInt());
        $this->assertSame('100', (string) $saturation);
    }

    public function testAdd()
    {
        $saturation = (new Saturation(12))->add(new Saturation(30));

        $this->assertInstanceOf(Saturation::class, $saturation);
        $this->assertSame(42, $saturation->toInt());

        $this->assertSame(
            100,
            (new Saturation(50))->add(new Saturation(75))->toInt()
        );
    }

    public function testSub()
    {
        $saturation = (new Saturation(54))->subtract(new Saturation(12));

        $this->assertInstanceOf(Saturation::class, $saturation);
        $this->assertSame(42, $saturation->toInt());

        $this->assertSame(
            0,
            (new Saturation(50))->subtract(new Saturation(75))->toInt()
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Saturation(-42);
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Saturation(101);
    }

    public function testEquals()
    {
        $this->assertTrue((new Saturation(50))->equals(new Saturation(50)));
        $this->assertFalse((new Saturation(100))->equals(new Saturation(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Saturation(100))->atMaximum());
        $this->assertFalse((new Saturation(0))->atMaximum());
        $this->assertFalse((new Saturation(50))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Saturation(100))->atMinimum());
        $this->assertTrue((new Saturation(0))->atMinimum());
        $this->assertFalse((new Saturation(50))->atMinimum());
    }
}
