<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Red,
    Intensity
};

class RedTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $red = new Red(255);

        $this->assertSame(255, $red->toInt());
        $this->assertSame('ff', (string) $red);
    }

    public function testFromHexadecimal()
    {
        $red = Red::fromHexadecimal('0f');

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(15, $red->toInt());
    }

    public function testAdd()
    {
        $red = (new Red(12))->add(new Red(30));

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(42, $red->toInt());

        $this->assertSame(
            255,
            (new Red(150))->add(new Red(150))->toInt()
        );
    }

    public function testSub()
    {
        $red = (new Red(54))->subtract(new Red(12));

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(42, $red->toInt());

        $this->assertSame(
            0,
            (new Red(150))->subtract(new Red(255))->toInt()
        );
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooLow()
    {
        new Red(-42);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueIsTooHigh()
    {
        new Red(512);
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Red(255))->atMaximum());
        $this->assertFalse((new Red(0))->atMaximum());
        $this->assertFalse((new Red(122))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Red(255))->atMinimum());
        $this->assertTrue((new Red(0))->atMinimum());
        $this->assertFalse((new Red(122))->atMinimum());
    }

    public function testFromIntensity()
    {
        $red = Red::fromIntensity(new Intensity(100));

        $this->assertInstanceOf(Red::class, $red);
        $this->assertSame(255, $red->toInt());
        $this->assertSame(
            191,
            Red::fromIntensity(new Intensity(75))->toInt()
        );
        $this->assertSame(
            128,
            Red::fromIntensity(new Intensity(50))->toInt()
        );
        $this->assertSame(
            64,
            Red::fromIntensity(new Intensity(25))->toInt()
        );
        $this->assertSame(
            0,
            Red::fromIntensity(new Intensity(0))->toInt()
        );
    }

    public function testEquals()
    {
        $this->assertTrue((new Red(50))->equals(new Red(50)));
        $this->assertFalse((new Red(100))->equals(new Red(50)));
    }
}
