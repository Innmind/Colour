<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Hue;
use Innmind\BlackBox\PHPUnit\Framework\{
    TestCase,
    Attributes\DataProvider,
};

class HueTest extends TestCase
{
    public function testInterface()
    {
        $hue = Hue::at(260);

        $this->assertSame(260, $hue->toInt());
        $this->assertSame('260', $hue->toString());
    }

    public function testThrowWhenValueTooLow()
    {
        $this
            ->assert()
            ->throws(
                static fn() => Hue::of(-20)->unwrap(),
                \OutOfBoundsException::class,
            );
    }

    public function testThrowWhenValueTooHigh()
    {
        $this
            ->assert()
            ->throws(
                static fn() => Hue::of(360)->unwrap(),
                \OutOfBoundsException::class,
            );
    }

    #[DataProvider('rotations')]
    public function testRotateBy($initial, $degrees, $expected)
    {
        $hue = Hue::at($initial)->rotateBy($degrees);

        $this->assertInstanceOf(Hue::class, $hue);
        $this->assertSame($expected, $hue->toInt());
    }

    public static function rotations(): array
    {
        return [
            [250, 50, 300],
            [250, -150, 100],
            [250, 250, 140],
            [100, -150, 310],
        ];
    }

    public function testOpposite()
    {
        $hue = Hue::at(150)->opposite();

        $this->assertInstanceOf(Hue::class, $hue);
        $this->assertSame(330, $hue->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue(Hue::at(50)->equals(Hue::at(50)));
        $this->assertFalse(Hue::at(100)->equals(Hue::at(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Hue::at(359)->atMaximum());
        $this->assertFalse(Hue::at(0)->atMaximum());
        $this->assertFalse(Hue::at(50)->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Hue::at(359)->atMinimum());
        $this->assertTrue(Hue::at(0)->atMinimum());
        $this->assertFalse(Hue::at(50)->atMinimum());
    }
}
