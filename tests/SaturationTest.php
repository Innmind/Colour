<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Saturation;

class SaturationTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $saturation = new Saturation(100);

        $this->assertSame(100, $saturation->toInt());
        $this->assertSame('100', (string) $saturation);
    }

    public function testAdd()
    {
        $saturation = (new Saturation(12))->add(new Saturation(30));

        $this->assertInstanceOf(Saturation::class, $saturation);
        $this->assertSame(42, $saturation->toInt());

        $this->assertSame(
            100,
            (new Saturation(50))->add(new Saturation(75))->toInt()
        );
    }

    public function testSub()
    {
        $saturation = (new Saturation(54))->subtract(new Saturation(12));

        $this->assertInstanceOf(Saturation::class, $saturation);
        $this->assertSame(42, $saturation->toInt());

        $this->assertSame(
            0,
            (new Saturation(50))->subtract(new Saturation(75))->toInt()
        );
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooLow()
    {
        new Saturation(-42);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooHigh()
    {
        new Saturation(101);
    }
}
