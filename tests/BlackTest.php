<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Black;

class BlackTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $black = new Black(50);

        $this->assertSame(50, $black->toInt());
        $this->assertSame('50', (string) $black);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooLow()
    {
        new Black(-1);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooHigh()
    {
        new Black(101);
    }

    public function testAdd()
    {
        $black = new Black(50);

        $black2 = $black->add(new Black(25));

        $this->assertInstanceOf(Black::class, $black2);
        $this->assertNotSame($black, $black2);
        $this->assertSame(50, $black->toInt());
        $this->assertSame(75, $black2->toInt());
    }

    public function testSubtract()
    {
        $black = new Black(50);

        $black2 = $black->subtract(new Black(25));

        $this->assertInstanceOf(Black::class, $black2);
        $this->assertNotSame($black, $black2);
        $this->assertSame(50, $black->toInt());
        $this->assertSame(25, $black2->toInt());
    }

    public function testEquals()
    {
        $this->assertTrue((new Black(50))->equals(new Black(50)));
        $this->assertFalse((new Black(100))->equals(new Black(50)));
    }
}
