<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Hue;

class HueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $hue = new Hue(260);

        $this->assertSame(260, $hue->toInt());
        $this->assertSame('260', (string) $hue);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooLow()
    {
        new Hue(-20);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooHigh()
    {
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

    public function rotations(): array
    {
        return [
            [250, 50, 300],
            [250, -150, 100],
            [250, 250, 140],
            [100, -150, 310]
        ];
    }

    public function testOpposite()
    {
        $hue = (new Hue(150))->opposite();

        $this->assertInstanceOf(Hue::class, $hue);
        $this->assertSame(330, $hue->toInt());
    }
}