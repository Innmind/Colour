<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Yellow;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class YellowTest extends TestCase
{
    public function testInterface()
    {
        $yellow = Yellow::at(50);

        $this->assertSame(50, $yellow->toInt());
        $this->assertSame('50', $yellow->toString());
    }

    public function testThrowWhenValueTooLow()
    {
        $this
            ->assert()
            ->throws(
                static fn() => Yellow::of(-1)->unwrap(),
                \OutOfBoundsException::class,
            );
    }

    public function testThrowWhenValueTooHigh()
    {
        $this
            ->assert()
            ->throws(
                static fn() => Yellow::of(101)->unwrap(),
                \OutOfBoundsException::class,
            );
    }

    public function testAdd()
    {
        $yellow = Yellow::at(50);

        $yellow2 = $yellow->add(Yellow::at(25));

        $this->assertInstanceOf(Yellow::class, $yellow2);
        $this->assertNotSame($yellow, $yellow2);
        $this->assertSame(50, $yellow->toInt());
        $this->assertSame(75, $yellow2->toInt());
    }

    public function testSubtract()
    {
        $yellow = Yellow::at(50);

        $yellow2 = $yellow->subtract(Yellow::at(25));

        $this->assertInstanceOf(Yellow::class, $yellow2);
        $this->assertNotSame($yellow, $yellow2);
        $this->assertSame(50, $yellow->toInt());
        $this->assertSame(25, $yellow2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue(Yellow::at(50)->equals(Yellow::at(50)));
        $this->assertFalse(Yellow::at(100)->equals(Yellow::at(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Yellow::at(100)->atMaximum());
        $this->assertFalse(Yellow::at(0)->atMaximum());
        $this->assertFalse(Yellow::at(50)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Yellow::at(100)->atMinimum());
        $this->assertTrue(Yellow::at(0)->atMinimum());
        $this->assertFalse(Yellow::at(50)->atMinimum());
    }
}
