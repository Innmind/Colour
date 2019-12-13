<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Magenta,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class MagentaTest extends TestCase
{
    public function testInterface()
    {
        $magenta = new Magenta(50);

        $this->assertSame(50, $magenta->toInt());
        $this->assertSame('50', (string) $magenta);
    }

    public function testThrowWhenValueTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-1');

        new Magenta(-1);
    }

    public function testThrowWhenValueTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('101');

        new Magenta(101);
    }

    public function testAdd()
    {
        $magenta = new Magenta(50);

        $magenta2 = $magenta->add(new Magenta(25));

        $this->assertInstanceOf(Magenta::class, $magenta2);
        $this->assertNotSame($magenta, $magenta2);
        $this->assertSame(50, $magenta->toInt());
        $this->assertSame(75, $magenta2->toInt());
    }

    public function testSubtract()
    {
        $magenta = new Magenta(50);

        $magenta2 = $magenta->subtract(new Magenta(25));

        $this->assertInstanceOf(Magenta::class, $magenta2);
        $this->assertNotSame($magenta, $magenta2);
        $this->assertSame(50, $magenta->toInt());
        $this->assertSame(25, $magenta2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue((new Magenta(50))->equals(new Magenta(50)));
        $this->assertFalse((new Magenta(100))->equals(new Magenta(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Magenta(100))->atMaximum());
        $this->assertFalse((new Magenta(0))->atMaximum());
        $this->assertFalse((new Magenta(50))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Magenta(100))->atMinimum());
        $this->assertTrue((new Magenta(0))->atMinimum());
        $this->assertFalse((new Magenta(50))->atMinimum());
    }
}
