<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Saturation;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SaturationTest extends TestCase
{
    public function testInterface()
    {
        $saturation = Saturation::at(100);

        $this->assertSame(100, $saturation->toInt());
        $this->assertSame('100', $saturation->toString());
    }

    public function testAdd()
    {
        $saturation = Saturation::at(12)->add(Saturation::at(30));

        $this->assertInstanceOf(Saturation::class, $saturation);
        $this->assertSame(42, $saturation->toInt());

        $this->assertSame(
            100,
            Saturation::at(50)->add(Saturation::at(75))->toInt(),
        );
    }

    public function testSub()
    {
        $saturation = Saturation::at(54)->subtract(Saturation::at(12));

        $this->assertInstanceOf(Saturation::class, $saturation);
        $this->assertSame(42, $saturation->toInt());

        $this->assertSame(
            0,
            Saturation::at(50)->subtract(Saturation::at(75))->toInt(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('-42');

        $_ = Saturation::of(-42)->unwrap();
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('101');

        $_ = Saturation::of(101)->unwrap();
    }

    public function testEquals()
    {
        $this->assertTrue(Saturation::at(50)->equals(Saturation::at(50)));
        $this->assertFalse(Saturation::at(100)->equals(Saturation::at(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Saturation::at(100)->atMaximum());
        $this->assertFalse(Saturation::at(0)->atMaximum());
        $this->assertFalse(Saturation::at(50)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Saturation::at(100)->atMinimum());
        $this->assertTrue(Saturation::at(0)->atMinimum());
        $this->assertFalse(Saturation::at(50)->atMinimum());
    }
}
