<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Magenta;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MagentaTest extends TestCase
{
    public function testInterface()
    {
        $magenta = Magenta::at(50);

        $this->assertSame(50, $magenta->toInt());
        $this->assertSame('50', $magenta->toString());
    }

    public function testThrowWhenValueTooLow()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('-1');

        $_ = Magenta::of(-1)->unwrap();
    }

    public function testThrowWhenValueTooHigh()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('101');

        $_ = Magenta::of(101)->unwrap();
    }

    public function testAdd()
    {
        $magenta = Magenta::at(50);

        $magenta2 = $magenta->add(Magenta::at(25));

        $this->assertInstanceOf(Magenta::class, $magenta2);
        $this->assertNotSame($magenta, $magenta2);
        $this->assertSame(50, $magenta->toInt());
        $this->assertSame(75, $magenta2->toInt());
    }

    public function testSubtract()
    {
        $magenta = Magenta::at(50);

        $magenta2 = $magenta->subtract(Magenta::at(25));

        $this->assertInstanceOf(Magenta::class, $magenta2);
        $this->assertNotSame($magenta, $magenta2);
        $this->assertSame(50, $magenta->toInt());
        $this->assertSame(25, $magenta2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue(Magenta::at(50)->equals(Magenta::at(50)));
        $this->assertFalse(Magenta::at(100)->equals(Magenta::at(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Magenta::at(100)->atMaximum());
        $this->assertFalse(Magenta::at(0)->atMaximum());
        $this->assertFalse(Magenta::at(50)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Magenta::at(100)->atMinimum());
        $this->assertTrue(Magenta::at(0)->atMinimum());
        $this->assertFalse(Magenta::at(50)->atMinimum());
    }
}
