<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Magenta;

class MagentaTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $magenta = new Magenta(50);

        $this->assertSame(50, $magenta->toInt());
        $this->assertSame('50', (string) $magenta);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooLow()
    {
        new Magenta(-1);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooHigh()
    {
        new Magenta(101);
    }

    public function testAdd()
    {
        $magenta = new Magenta(50);

        $magenta2 = $magenta->add(new Magenta(25));

        $this->assertInstanceOf(Magenta::class, $magenta2);
        $this->assertNotSame($magenta, $magenta2);
        $this->assertSame(50, $magenta->toInt());
        $this->assertSame(75, $magenta2->toInt());
    }

    public function testSubtract()
    {
        $magenta = new Magenta(50);

        $magenta2 = $magenta->subtract(new Magenta(25));

        $this->assertInstanceOf(Magenta::class, $magenta2);
        $this->assertNotSame($magenta, $magenta2);
        $this->assertSame(50, $magenta->toInt());
        $this->assertSame(25, $magenta2->toInt());
    }
}
