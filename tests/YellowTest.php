<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Yellow;

class YellowTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $yellow = new Yellow(50);

        $this->assertSame(50, $yellow->toInt());
        $this->assertSame('50', (string) $yellow);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooLow()
    {
        new Yellow(-1);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooHigh()
    {
        new Yellow(101);
    }

    public function testAdd()
    {
        $yellow = new Yellow(50);

        $yellow2 = $yellow->add(new Yellow(25));

        $this->assertInstanceOf(Yellow::class, $yellow2);
        $this->assertNotSame($yellow, $yellow2);
        $this->assertSame(50, $yellow->toInt());
        $this->assertSame(75, $yellow2->toInt());
    }

    public function testSubtract()
    {
        $yellow = new Yellow(50);

        $yellow2 = $yellow->subtract(new Yellow(25));

        $this->assertInstanceOf(Yellow::class, $yellow2);
        $this->assertNotSame($yellow, $yellow2);
        $this->assertSame(50, $yellow->toInt());
        $this->assertSame(25, $yellow2->toInt());
    }
}
