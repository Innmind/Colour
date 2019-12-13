<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Black,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class BlackTest extends TestCase
{
    public function testInterface()
    {
        $black = new Black(50);

        $this->assertSame(50, $black->toInt());
        $this->assertSame('50', (string) $black);
    }

    public function testThrowWhenValueTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-1');

        new Black(-1);
    }

    public function testThrowWhenValueTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('101');

        new Black(101);
    }

    public function testAdd()
    {
        $black = new Black(50);

        $black2 = $black->add(new Black(25));

        $this->assertInstanceOf(Black::class, $black2);
        $this->assertNotSame($black, $black2);
        $this->assertSame(50, $black->toInt());
        $this->assertSame(75, $black2->toInt());
    }

    public function testSubtract()
    {
        $black = new Black(50);

        $black2 = $black->subtract(new Black(25));

        $this->assertInstanceOf(Black::class, $black2);
        $this->assertNotSame($black, $black2);
        $this->assertSame(50, $black->toInt());
        $this->assertSame(25, $black2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue((new Black(50))->equals(new Black(50)));
        $this->assertFalse((new Black(100))->equals(new Black(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Black(100))->atMaximum());
        $this->assertFalse((new Black(0))->atMaximum());
        $this->assertFalse((new Black(50))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Black(100))->atMinimum());
        $this->assertTrue((new Black(0))->atMinimum());
        $this->assertFalse((new Black(50))->atMinimum());
    }
}
