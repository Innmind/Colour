<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    CMYKA,
    Cyan,
    Magenta,
    Yellow,
    Black,
    Alpha,
    RGBA,
    Convertible,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class CMYKATest extends TestCase
{
    public function testInterface()
    {
        $cmyk = new CMYKA(
            $cyan = new Cyan(10),
            $magenta = new Magenta(20),
            $yellow = new Yellow(30),
            $black = new Black(40)
        );

        $this->assertSame($cyan, $cmyk->cyan());
        $this->assertSame($magenta, $cmyk->magenta());
        $this->assertSame($yellow, $cmyk->yellow());
        $this->assertSame($black, $cmyk->black());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame('device-cmyk(10%, 20%, 30%, 40%)', (string) $cmyk);

        $cmyka = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40),
            $alpha = new Alpha(0.5)
        );

        $this->assertSame($alpha, $cmyka->alpha());
        $this->assertSame('device-cmyk(10%, 20%, 30%, 40%, 0.5)', (string) $cmyka);
    }

    public function testAddCyan()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->addCyan(new Cyan(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(11, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testSubtractCyan()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->subtractCyan(new Cyan(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(9, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testAddMagenta()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->addMagenta(new Magenta(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(21, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testSubtractMagenta()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->subtractMagenta(new Magenta(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(19, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testAddYellow()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->addYellow(new Yellow(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(31, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testSubtractYellow()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->subtractYellow(new Yellow(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(29, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testAddBlack()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->addBlack(new Black(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(41, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testSubtractBlack()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->subtractBlack(new Black(1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(39, $cmyk2->black()->toInt());
        $this->assertSame(1.0, $cmyk2->alpha()->toFloat());
    }

    public function testAddAlpha()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40),
            new Alpha(0.1)
        );

        $cmyk2 = $cmyk->addAlpha(new Alpha(0.1));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(0.1, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(0.2, $cmyk2->alpha()->toFloat());
    }

    public function testSubtractAlpha()
    {
        $cmyk = new CMYKA(
            new Cyan(10),
            new Magenta(20),
            new Yellow(30),
            new Black(40)
        );

        $cmyk2 = $cmyk->subtractAlpha(new Alpha(0.9));

        $this->assertInstanceOf(CMYKA::class, $cmyk2);
        $this->assertNotSame($cmyk, $cmyk2);
        $this->assertSame(10, $cmyk->cyan()->toInt());
        $this->assertSame(20, $cmyk->magenta()->toInt());
        $this->assertSame(30, $cmyk->yellow()->toInt());
        $this->assertSame(40, $cmyk->black()->toInt());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame(10, $cmyk2->cyan()->toInt());
        $this->assertSame(20, $cmyk2->magenta()->toInt());
        $this->assertSame(30, $cmyk2->yellow()->toInt());
        $this->assertSame(40, $cmyk2->black()->toInt());
        $this->assertSame(0.1, $cmyk2->alpha()->toFloat());
    }

    /**
     * @dataProvider withAlpha
     */
    public function testWithAlpha(
        string $string,
        int $cyan,
        int $magenta,
        int $yellow,
        int $black,
        float $alpha
    ) {
        $cmyka = CMYKA::withAlpha(
            Str::of($string)
        );

        $this->assertInstanceOf(CMYKA::class, $cmyka);
        $this->assertSame($cyan, $cmyka->cyan()->toInt());
        $this->assertSame($magenta, $cmyka->magenta()->toInt());
        $this->assertSame($yellow, $cmyka->yellow()->toInt());
        $this->assertSame($black, $cmyka->black()->toInt());
        $this->assertSame($alpha, $cmyka->alpha()->toFloat());
    }

    public function testThrowWhenBuildingFromStringWithUnfoundAlpha()
    {
        $this->expectException(DomainException::class);

        CMYKA::withAlpha(
            Str::of('device-cmyk(10%, 20%, 30%, 40%)')
        );
    }

    public function withAlpha()
    {
        return [
            ['device-cmyk(10%, 20%, 30%, 40%, 1.0)', 10, 20, 30, 40, 1.0],
            ['device-cmyk(10%, 20%, 30%, 40%, 1)', 10, 20, 30, 40, 1.0],
            ['device-cmyk(10%, 20%, 30%, 40%, 0)', 10, 20, 30, 40, 0.0],
            ['device-cmyk(10%, 20%, 30%, 40%, 0.0)', 10, 20, 30, 40, 0.0],
            ['device-cmyk(10%, 20%, 30%, 40%, 0.5)', 10, 20, 30, 40, 0.5],
            ['device-cmyk(40%,30%,20%,10%,0.5)', 40, 30, 20, 10, 0.5],
        ];
    }

    /**
     * @dataProvider withoutAlpha
     */
    public function testWithoutAlpha(
        string $string,
        int $cyan,
        int $magenta,
        int $yellow,
        int $black
    ) {
        $cmyka = CMYKA::withoutAlpha(
            Str::of($string)
        );

        $this->assertInstanceOf(CMYKA::class, $cmyka);
        $this->assertSame($cyan, $cmyka->cyan()->toInt());
        $this->assertSame($magenta, $cmyka->magenta()->toInt());
        $this->assertSame($yellow, $cmyka->yellow()->toInt());
        $this->assertSame($black, $cmyka->black()->toInt());
        $this->assertTrue($cmyka->alpha()->atMaximum());
    }

    public function testThrowWhenBuildingFromStringWithFoundAlpha()
    {
        $this->expectException(DomainException::class);

        CMYKA::withoutAlpha(
            Str::of('device-cmyk(10%, 20%, 30%, 40%, 1.0)')
        );
    }

    public function withoutAlpha()
    {
        return [
            ['device-cmyk(10%, 20%, 30%, 40%)', 10, 20, 30, 40],
            ['device-cmyk(40%,30%,20%,10%)', 40, 30, 20, 10],
        ];
    }

    /**
     * @dataProvider colours
     */
    public function testOf(
        string $string,
        int $cyan,
        int $magenta,
        int $yellow,
        int $black,
        float $alpha = null
    ) {
        $cmyka = CMYKA::of($string);

        $this->assertInstanceOf(CMYKA::class, $cmyka);
        $this->assertSame($cyan, $cmyka->cyan()->toInt());
        $this->assertSame($magenta, $cmyka->magenta()->toInt());
        $this->assertSame($yellow, $cmyka->yellow()->toInt());
        $this->assertSame($black, $cmyka->black()->toInt());
        $this->assertSame($alpha ?? 1.0, $cmyka->alpha()->toFloat());
    }

    public function colours()
    {
        return array_merge($this->withAlpha(), $this->withoutAlpha());
    }

    public function testToRGBA()
    {
        $rgba = ($cmyka = CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)'))->toRGBA();

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame(51, $rgba->red()->toInt());
        $this->assertSame(153, $rgba->green()->toInt());
        $this->assertSame(255, $rgba->blue()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertSame($rgba, $cmyka->toRGBA());
    }

    public function testToHSLA()
    {
        $cmyka = CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)');

        $this->assertTrue($cmyka->toHSLA()->equals($cmyka->toRGBA()->toHSLA()));
        $this->assertSame($cmyka->toHSLA(), $cmyka->toHSLA());
    }

    public function testEquals()
    {
        $this->assertTrue(
            CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)')->equals(
                CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)')
            )
        );
        $this->assertFalse(
            CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 1.0)')->equals(
                CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)')
            )
        );
    }

    public function testConvertible()
    {
        $cmyka = CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)');

        $this->assertInstanceOf(Convertible::class, $cmyka);
        $this->assertSame($cmyka, $cmyka->toCMYKA());
    }
}
