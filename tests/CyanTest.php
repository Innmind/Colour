<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Cyan,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class CyanTest extends TestCase
{
    public function testInterface()
    {
        $cyan = new Cyan(50);

        $this->assertSame(50, $cyan->toInt());
        $this->assertSame('50', (string) $cyan);
    }

    public function testThrowWhenValueTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Cyan(-1);
    }

    public function testThrowWhenValueTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);

        new Cyan(101);
    }

    public function testAdd()
    {
        $cyan = new Cyan(50);

        $cyan2 = $cyan->add(new Cyan(25));

        $this->assertInstanceOf(Cyan::class, $cyan2);
        $this->assertNotSame($cyan, $cyan2);
        $this->assertSame(50, $cyan->toInt());
        $this->assertSame(75, $cyan2->toInt());
    }

    public function testSubtract()
    {
        $cyan = new Cyan(50);

        $cyan2 = $cyan->subtract(new Cyan(25));

        $this->assertInstanceOf(Cyan::class, $cyan2);
        $this->assertNotSame($cyan, $cyan2);
        $this->assertSame(50, $cyan->toInt());
        $this->assertSame(25, $cyan2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue((new Cyan(50))->equals(new Cyan(50)));
        $this->assertFalse((new Cyan(100))->equals(new Cyan(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Cyan(100))->atMaximum());
        $this->assertFalse((new Cyan(0))->atMaximum());
        $this->assertFalse((new Cyan(50))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Cyan(100))->atMinimum());
        $this->assertTrue((new Cyan(0))->atMinimum());
        $this->assertFalse((new Cyan(50))->atMinimum());
    }
}
