<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Cyan,
    Exception\InvalidValueRangeException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CyanTest extends TestCase
{
    public function testInterface()
    {
        $cyan = Cyan::at(50);

        $this->assertSame(50, $cyan->toInt());
        $this->assertSame('50', $cyan->toString());
    }

    public function testThrowWhenValueTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-1');

        Cyan::of(-1)->unwrap();
    }

    public function testThrowWhenValueTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('101');

        Cyan::of(101)->unwrap();
    }

    public function testAdd()
    {
        $cyan = Cyan::at(50);

        $cyan2 = $cyan->add(Cyan::at(25));

        $this->assertInstanceOf(Cyan::class, $cyan2);
        $this->assertNotSame($cyan, $cyan2);
        $this->assertSame(50, $cyan->toInt());
        $this->assertSame(75, $cyan2->toInt());
    }

    public function testSubtract()
    {
        $cyan = Cyan::at(50);

        $cyan2 = $cyan->subtract(Cyan::at(25));

        $this->assertInstanceOf(Cyan::class, $cyan2);
        $this->assertNotSame($cyan, $cyan2);
        $this->assertSame(50, $cyan->toInt());
        $this->assertSame(25, $cyan2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue(Cyan::at(50)->equals(Cyan::at(50)));
        $this->assertFalse(Cyan::at(100)->equals(Cyan::at(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Cyan::at(100)->atMaximum());
        $this->assertFalse(Cyan::at(0)->atMaximum());
        $this->assertFalse(Cyan::at(50)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Cyan::at(100)->atMinimum());
        $this->assertTrue(Cyan::at(0)->atMinimum());
        $this->assertFalse(Cyan::at(50)->atMinimum());
    }
}
