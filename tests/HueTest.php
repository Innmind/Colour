<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Hue,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class HueTest extends TestCase
{
    public function testInterface()
    {
        $hue = new Hue(260);

        $this->assertSame(260, $hue->toInt());
        $this->assertSame('260', $hue->toString());
    }

    public function testThrowWhenValueTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-20');

        new Hue(-20);
    }

    public function testThrowWhenValueTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('360');

        new Hue(360);
    }

    /**
     * @dataProvider rotations
     */
    public function testRotateBy($initial, $degrees, $expected)
    {
        $hue = (new Hue($initial))->rotateBy($degrees);

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
        $hue = (new Hue(150))->opposite();

        $this->assertInstanceOf(Hue::class, $hue);
        $this->assertSame(330, $hue->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue((new Hue(50))->equals(new Hue(50)));
        $this->assertFalse((new Hue(100))->equals(new Hue(50)));
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Hue(359))->atMaximum());
        $this->assertFalse((new Hue(0))->atMaximum());
        $this->assertFalse((new Hue(50))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Hue(359))->atMinimum());
        $this->assertTrue((new Hue(0))->atMinimum());
        $this->assertFalse((new Hue(50))->atMinimum());
    }
}
