<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Black;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class BlackTest extends TestCase
{
    public function testInterface()
    {
        $black = Black::at(50);

        $this->assertSame(50, $black->toInt());
        $this->assertSame('50', $black->toString());
    }

    public function testThrowWhenValueTooLow()
    {
        $this
            ->assert()
            ->throws(
                static fn() => Black::of(-1)->unwrap(),
                \OutOfBoundsException::class,
            );
    }

    public function testThrowWhenValueTooHigh()
    {
        $this
            ->assert()
            ->throws(
                static fn() => Black::of(101)->unwrap(),
                \OutOfBoundsException::class,
            );
    }

    public function testAdd()
    {
        $black = Black::at(50);

        $black2 = $black->add(Black::at(25));

        $this->assertInstanceOf(Black::class, $black2);
        $this->assertNotSame($black, $black2);
        $this->assertSame(50, $black->toInt());
        $this->assertSame(75, $black2->toInt());
    }

    public function testSubtract()
    {
        $black = Black::at(50);

        $black2 = $black->subtract(Black::at(25));

        $this->assertInstanceOf(Black::class, $black2);
        $this->assertNotSame($black, $black2);
        $this->assertSame(50, $black->toInt());
        $this->assertSame(25, $black2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue(Black::at(50)->equals(Black::at(50)));
        $this->assertFalse(Black::at(100)->equals(Black::at(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Black::at(100)->atMaximum());
        $this->assertFalse(Black::at(0)->atMaximum());
        $this->assertFalse(Black::at(50)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Black::at(100)->atMinimum());
        $this->assertTrue(Black::at(0)->atMinimum());
        $this->assertFalse(Black::at(50)->atMinimum());
    }
}
