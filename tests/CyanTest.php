<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Cyan;

class CyanTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $cyan = new Cyan(50);

        $this->assertSame(50, $cyan->toInt());
        $this->assertSame('50', (string) $cyan);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooLow()
    {
        new Cyan(-1);
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidValueRangeException
     */
    public function testThrowWhenValueTooHigh()
    {
        new Cyan(101);
    }

    public function testAdd()
    {
        $cyan = new Cyan(50);

        $cyan2 = $cyan->add(new Cyan(25));

        $this->assertInstanceOf(Cyan::class, $cyan2);
        $this->assertNotSame($cyan, $cyan2);
        $this->assertSame(50, $cyan->toInt());
        $this->assertSame(75, $cyan2->toInt());
    }

    public function testSubtract()
    {
        $cyan = new Cyan(50);

        $cyan2 = $cyan->subtract(new Cyan(25));

        $this->assertInstanceOf(Cyan::class, $cyan2);
        $this->assertNotSame($cyan, $cyan2);
        $this->assertSame(50, $cyan->toInt());
        $this->assertSame(25, $cyan2->toInt());
    }
}
