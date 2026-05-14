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
};
use Innmind\BlackBox\PHPUnit\Framework\{
    TestCase,
    Attributes\DataProvider,
};

class CMYKATest extends TestCase
{
    public function testInterface()
    {
        $cmyk = CMYKA::from(
            $cyan = Cyan::at(10),
            $magenta = Magenta::at(20),
            $yellow = Yellow::at(30),
            $black = Black::at(40),
        );

        $this->assertSame($cyan, $cmyk->cyan());
        $this->assertSame($magenta, $cmyk->magenta());
        $this->assertSame($yellow, $cmyk->yellow());
        $this->assertSame($black, $cmyk->black());
        $this->assertSame(1.0, $cmyk->alpha()->toFloat());
        $this->assertSame('device-cmyk(10%, 20%, 30%, 40%)', $cmyk->toString());

        $cmyka = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
            $alpha = Alpha::of(0.5)->unwrap(),
        );

        $this->assertSame($alpha, $cmyka->alpha());
        $this->assertSame('device-cmyk(10%, 20%, 30%, 40%, 0.5)', $cmyka->toString());
    }

    public function testAddCyan()
    {
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->addCyan(Cyan::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->subtractCyan(Cyan::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->addMagenta(Magenta::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->subtractMagenta(Magenta::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->addYellow(Yellow::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->subtractYellow(Yellow::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->addBlack(Black::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->subtractBlack(Black::at(1));

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
            Alpha::of(0.1)->unwrap(),
        );

        $cmyk2 = $cmyk->addAlpha(Alpha::of(0.1)->unwrap());

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
        $cmyk = CMYKA::from(
            Cyan::at(10),
            Magenta::at(20),
            Yellow::at(30),
            Black::at(40),
        );

        $cmyk2 = $cmyk->subtractAlpha(Alpha::of(0.9)->unwrap());

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
        $this->assertGreaterThanOrEqual(0.09, $cmyk2->alpha()->toFloat());
        $this->assertLessThanOrEqual(0.11, $cmyk2->alpha()->toFloat());
    }

    #[DataProvider('withAlpha')]
    public function testWithAlpha(
        string $string,
        int $cyan,
        int $magenta,
        int $yellow,
        int $black,
        float $alpha,
    ) {
        $cmyka = CMYKA::of($string);

        $this->assertInstanceOf(CMYKA::class, $cmyka);
        $this->assertSame($cyan, $cmyka->cyan()->toInt());
        $this->assertSame($magenta, $cmyka->magenta()->toInt());
        $this->assertSame($yellow, $cmyka->yellow()->toInt());
        $this->assertSame($black, $cmyka->black()->toInt());
        $this->assertSame($alpha, $cmyka->alpha()->toFloat());
    }

    public static function withAlpha()
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

    #[DataProvider('withoutAlpha')]
    public function testWithoutAlpha(
        string $string,
        int $cyan,
        int $magenta,
        int $yellow,
        int $black,
    ) {
        $cmyka = CMYKA::of($string);

        $this->assertInstanceOf(CMYKA::class, $cmyka);
        $this->assertSame($cyan, $cmyka->cyan()->toInt());
        $this->assertSame($magenta, $cmyka->magenta()->toInt());
        $this->assertSame($yellow, $cmyka->yellow()->toInt());
        $this->assertSame($black, $cmyka->black()->toInt());
        $this->assertTrue($cmyka->alpha()->atMaximum());
    }

    public static function withoutAlpha()
    {
        return [
            ['device-cmyk(10%, 20%, 30%, 40%)', 10, 20, 30, 40],
            ['device-cmyk(40%,30%,20%,10%)', 40, 30, 20, 10],
        ];
    }

    #[DataProvider('colours')]
    public function testOf(
        string $string,
        int $cyan,
        int $magenta,
        int $yellow,
        int $black,
        ?float $alpha = null,
    ) {
        $cmyka = CMYKA::of($string);

        $this->assertInstanceOf(CMYKA::class, $cmyka);
        $this->assertSame($cyan, $cmyka->cyan()->toInt());
        $this->assertSame($magenta, $cmyka->magenta()->toInt());
        $this->assertSame($yellow, $cmyka->yellow()->toInt());
        $this->assertSame($black, $cmyka->black()->toInt());
        $this->assertSame($alpha ?? 1.0, $cmyka->alpha()->toFloat());
    }

    public static function colours()
    {
        return \array_merge(self::withAlpha(), self::withoutAlpha());
    }

    public function testToRGBA()
    {
        $rgba = ($cmyka = CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)'))->toRGBA();

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame(51, $rgba->red()->toInt());
        $this->assertSame(153, $rgba->green()->toInt());
        $this->assertSame(255, $rgba->blue()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertTrue($rgba->equals($cmyka->toRGBA()));
    }

    public function testToHSLA()
    {
        $cmyka = CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)');

        $this->assertTrue($cmyka->toHSLA()->equals($cmyka->toRGBA()->toHSLA()));
    }

    public function testEquals()
    {
        $this->assertTrue(
            CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)')->equals(
                CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)'),
            ),
        );
        $this->assertFalse(
            CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 1.0)')->equals(
                CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)'),
            ),
        );
    }

    public function testConvertible()
    {
        $cmyka = CMYKA::of('device-cmyk(80%, 40%, 0%, 0%, 0.5)');

        $this->assertSame($cmyka, $cmyka->toCMYKA());
    }
}
