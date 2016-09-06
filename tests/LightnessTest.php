<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Lightness;

class LightnessTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $lightness = new Lightness(100);

        $this->assertSame(100, $lightness->toInt());
        $this->assertSame('100', (string) $lightness);
    }

    public function testAdd()
    {
        $lightness = (new Lightness(12))->add(new Lightness(30));

        $this->assertInstanceOf(Lightness::class, $lightness);
        $this->assertSame(42, $lightness->toInt());

        $this->assertSame(
            100,
            (new Lightness(50))->add(new Lightness(75))->toInt()
        );
    }

    public function testSub()
    {
        $lightness = (new Lightness(54))->subtract(new Lightness(12));

        $this->assertInstanceOf(Lightness::class, $lightness);
        $this->assertSame(42, $lightness->toInt());

        $this->assertSame(
            0,
            (new Lightness(50))->subtract(new Lightness(75))->toInt()
        );
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooLow()
    {
        new Lightness(-42);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooHigh()
    {
        new Lightness(101);
    }
}
