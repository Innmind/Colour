<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\Alpha;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AlphaTest extends TestCase
{
    public function testInterface()
    {
        $alpha = Alpha::of(0.5)->unwrap();

        $this->assertSame(0.5, $alpha->toFloat());
        $this->assertSame('0.5', $alpha->toString());
    }

    public function testAdd()
    {
        $alpha = Alpha::of(0.12)->unwrap()->add(Alpha::of(0.30)->unwrap());

        $this->assertInstanceOf(Alpha::class, $alpha);
        $this->assertSame(0.42, $alpha->toFloat());

        $this->assertSame(
            1.0,
            Alpha::of(0.6)->unwrap()->add(Alpha::of(0.7)->unwrap())->toFloat(),
        );
    }

    public function testSub()
    {
        $alpha = Alpha::of(0.54)->unwrap()->subtract(Alpha::of(0.12)->unwrap());

        $this->assertInstanceOf(Alpha::class, $alpha);
        $this->assertGreaterThanOrEqual(0.4199, $alpha->toFloat());
        $this->assertLessThanOrEqual(0.421, $alpha->toFloat());

        $this->assertSame(
            0.0,
            Alpha::of(0.5)->unwrap()->subtract(Alpha::of(0.7)->unwrap())->toFloat(),
        );
    }

    public function testThrowWhenValueIsTooLow()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('-0.1');

        $_ = Alpha::of(-0.1)->unwrap();
    }

    public function testThrowWhenValueIsTooHigh()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('1.1');

        $_ = Alpha::of(1.1)->unwrap();
    }

    public function testAtMaximum()
    {
        $this->assertTrue(Alpha::of(1)->unwrap()->atMaximum());
        $this->assertFalse(Alpha::of(0)->unwrap()->atMaximum());
        $this->assertFalse(Alpha::of(0.5)->unwrap()->atMaximum());
    }

    public function testAtMinimum()
    {
        $this->assertFalse(Alpha::of(1)->unwrap()->atMinimum());
        $this->assertTrue(Alpha::of(0)->unwrap()->atMinimum());
        $this->assertFalse(Alpha::of(0.5)->unwrap()->atMinimum());
    }

    #[DataProvider('hexadecimals')]
    public function testHexadecimal($hex, $percent)
    {
        $this->assertSame(
            $hex,
            Alpha::of($percent)->unwrap()->toHexadecimal(),
        );

        $alpha = Alpha::fromHexadecimal($hex)->match(
            static fn($alpha) => $alpha,
            static fn() => null,
        );
        $this->assertInstanceOf(Alpha::class, $alpha);
        $this->assertSame($percent, $alpha->toFloat());
    }

    public static function hexadecimals()
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
        $this->assertTrue(Alpha::of(0.5)->unwrap()->equals(Alpha::of(0.5)->unwrap()));
        $this->assertFalse(Alpha::of(1.0)->unwrap()->equals(Alpha::of(0.5)->unwrap()));
    }
}
