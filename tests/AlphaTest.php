<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Alpha,
    Exception\InvalidValueRangeException,
};
use PHPUnit\Framework\TestCase;

class AlphaTest extends TestCase
{
    public function testInterface()
    {
        $alpha = new Alpha(0.5);

        $this->assertSame(0.5, $alpha->toFloat());
        $this->assertSame('0.5', $alpha->toString());
    }

    public function testAdd()
    {
        $alpha = (new Alpha(0.12))->add(new Alpha(0.30));

        $this->assertInstanceOf(Alpha::class, $alpha);
        $this->assertSame(0.42, $alpha->toFloat());

        $this->assertSame(
            1.0,
            (new Alpha(0.6))->add(new Alpha(0.7))->toFloat(),
        );
    }

    public function testSub()
    {
        $alpha = (new Alpha(0.54))->subtract(new Alpha(0.12));

        $this->assertInstanceOf(Alpha::class, $alpha);
        $this->assertSame(0.42, $alpha->toFloat());

        $this->assertSame(
            0.0,
            (new Alpha(0.5))->subtract(new Alpha(0.7))->toFloat(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('-0.1');

        new Alpha(-0.1);
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(InvalidValueRangeException::class);
        $this->expectExceptionMessage('1.1');

        new Alpha(1.1);
    }

    public function testAtMaximum()
    {
        $this->assertTrue((new Alpha(1))->atMaximum());
        $this->assertFalse((new Alpha(0))->atMaximum());
        $this->assertFalse((new Alpha(0.5))->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse((new Alpha(1))->atMinimum());
        $this->assertTrue((new Alpha(0))->atMinimum());
        $this->assertFalse((new Alpha(0.5))->atMinimum());
    }

    /**
     * @dataProvider hexadecimals
     */
    public function testHexadecimal($hex, $percent)
    {
        $this->assertSame(
            $hex,
            (new Alpha($percent))->toHexadecimal(),
        );

        $alpha = Alpha::fromHexadecimal($hex)->match(
            static fn($alpha) => $alpha,
            static fn() => null,
        );
        $this->assertInstanceOf(Alpha::class, $alpha);
        $this->assertSame($percent, $alpha->toFloat());
    }

    public function hexadecimals()
    {
        return [
            ['ff', 1.0],
            ['f2', 0.95],
            ['e6', 0.9],
            ['d9', 0.85],
            ['cc', 0.8],
            ['bf', 0.75],
            ['b3', 0.7],
            ['a6', 0.65],
            ['99', 0.6],
            ['8c', 0.55],
            ['80', 0.5],
            ['73', 0.45],
            ['66', 0.4],
            ['59', 0.35],
            ['4d', 0.3],
            ['40', 0.25],
            ['33', 0.2],
            ['26', 0.15],
            ['1a', 0.1],
            ['0d', 0.05],
            ['00', 0.0],
        ];
    }

    public function testEquals()
    {
        $this->assertTrue((new Alpha(0.5))->equals(new Alpha(0.5)));
        $this->assertFalse((new Alpha(1.0))->equals(new Alpha(0.5)));
    }
}
