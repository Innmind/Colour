<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Yellow,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class YellowTest extends TestCase
{
    public function testInterface()
    {
        $yellow = new Yellow(50);

        $this->assertSame(50, $yellow->toInt());
        $this->assertSame('50', $yellow->toString());
    }

    public function testThrowWhenValueTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-1');

        new Yellow(-1);
    }

    public function testThrowWhenValueTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('101');

        new Yellow(101);
    }

    public function testAdd()
    {
        $yellow = new Yellow(50);

        $yellow2 = $yellow->add(new Yellow(25));

        $this->assertInstanceOf(Yellow::class, $yellow2);
        $this->assertNotSame($yellow, $yellow2);
        $this->assertSame(50, $yellow->toInt());
        $this->assertSame(75, $yellow2->toInt());
    }

    public function testSubtract()
    {
        $yellow = new Yellow(50);

        $yellow2 = $yellow->subtract(new Yellow(25));

        $this->assertInstanceOf(Yellow::class, $yellow2);
        $this->assertNotSame($yellow, $yellow2);
        $this->assertSame(50, $yellow->toInt());
        $this->assertSame(25, $yellow2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue((new Yellow(50))->equals(new Yellow(50)));
        $this->assertFalse((new Yellow(100))->equals(new Yellow(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Yellow(100))->atMaximum());
        $this->assertFalse((new Yellow(0))->atMaximum());
        $this->assertFalse((new Yellow(50))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Yellow(100))->atMinimum());
        $this->assertTrue((new Yellow(0))->atMinimum());
        $this->assertFalse((new Yellow(50))->atMinimum());
    }
}
