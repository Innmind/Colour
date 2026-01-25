<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    HSLA,
    Hue,
    Saturation,
    Lightness,
    Alpha,
    RGBA,
    CMYKA,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class HSLATest extends TestCase
{
    public function testInterface()
    {
        $hsl = HSLA::from(
            $hue = Hue::at(150),
            $saturation = Saturation::at(42),
            $lightness = Lightness::at(24),
        );

        $this->assertSame($hue, $hsl->hue());
        $this->assertSame($saturation, $hsl->saturation());
        $this->assertSame($lightness, $hsl->lightness());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame('hsl(150, 42%, 24%)', $hsl->toString());

        $hsla = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
            $alpha = Alpha::of(0.5)->unwrap(),
        );

        $this->assertSame($alpha, $hsla->alpha());
        $this->assertSame('hsla(150, 42%, 24%, 0.5)', $hsla->toString());
    }

    public function testRotateBy()
    {
        $hsl = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
        );

        $hsl2 = $hsl->rotateBy(50);

        $this->assertInstanceOf(HSLA::class, $hsl2);
        $this->assertNotSame($hsl, $hsl2);
        $this->assertSame(150, $hsl->hue()->toInt());
        $this->assertSame(42, $hsl->saturation()->toInt());
        $this->assertSame(24, $hsl->lightness()->toInt());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame(200, $hsl2->hue()->toInt());
        $this->assertSame(42, $hsl2->saturation()->toInt());
        $this->assertSame(24, $hsl2->lightness()->toInt());
        $this->assertSame(1.0, $hsl2->alpha()->toFloat());
    }

    public function testAddSaturation()
    {
        $hsl = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
        );

        $hsl2 = $hsl->addSaturation(Saturation::at(58));

        $this->assertInstanceOf(HSLA::class, $hsl2);
        $this->assertNotSame($hsl, $hsl2);
        $this->assertSame(150, $hsl->hue()->toInt());
        $this->assertSame(42, $hsl->saturation()->toInt());
        $this->assertSame(24, $hsl->lightness()->toInt());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame(150, $hsl2->hue()->toInt());
        $this->assertSame(100, $hsl2->saturation()->toInt());
        $this->assertSame(24, $hsl2->lightness()->toInt());
        $this->assertSame(1.0, $hsl2->alpha()->toFloat());
    }

    public function testSubtractSaturation()
    {
        $hsl = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
        );

        $hsl2 = $hsl->SubtractSaturation(Saturation::at(22));

        $this->assertInstanceOf(HSLA::class, $hsl2);
        $this->assertNotSame($hsl, $hsl2);
        $this->assertSame(150, $hsl->hue()->toInt());
        $this->assertSame(42, $hsl->saturation()->toInt());
        $this->assertSame(24, $hsl->lightness()->toInt());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame(150, $hsl2->hue()->toInt());
        $this->assertSame(20, $hsl2->saturation()->toInt());
        $this->assertSame(24, $hsl2->lightness()->toInt());
        $this->assertSame(1.0, $hsl2->alpha()->toFloat());
    }

    public function testAddLightness()
    {
        $hsl = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
        );

        $hsl2 = $hsl->addLightness(Lightness::at(6));

        $this->assertInstanceOf(HSLA::class, $hsl2);
        $this->assertNotSame($hsl, $hsl2);
        $this->assertSame(150, $hsl->hue()->toInt());
        $this->assertSame(42, $hsl->saturation()->toInt());
        $this->assertSame(24, $hsl->lightness()->toInt());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame(150, $hsl2->hue()->toInt());
        $this->assertSame(42, $hsl2->saturation()->toInt());
        $this->assertSame(30, $hsl2->lightness()->toInt());
        $this->assertSame(1.0, $hsl2->alpha()->toFloat());
    }

    public function testSubtractLightness()
    {
        $hsl = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
        );

        $hsl2 = $hsl->subtractLightness(Lightness::at(22));

        $this->assertInstanceOf(HSLA::class, $hsl2);
        $this->assertNotSame($hsl, $hsl2);
        $this->assertSame(150, $hsl->hue()->toInt());
        $this->assertSame(42, $hsl->saturation()->toInt());
        $this->assertSame(24, $hsl->lightness()->toInt());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame(150, $hsl2->hue()->toInt());
        $this->assertSame(42, $hsl2->saturation()->toInt());
        $this->assertSame(2, $hsl2->lightness()->toInt());
        $this->assertSame(1.0, $hsl2->alpha()->toFloat());
    }

    public function testAddAlpha()
    {
        $hsl = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
            Alpha::of(0.1)->unwrap(),
        );

        $hsl2 = $hsl->addALpha(Alpha::of(0.1)->unwrap());

        $this->assertInstanceOf(HSLA::class, $hsl2);
        $this->assertNotSame($hsl, $hsl2);
        $this->assertSame(150, $hsl->hue()->toInt());
        $this->assertSame(42, $hsl->saturation()->toInt());
        $this->assertSame(24, $hsl->lightness()->toInt());
        $this->assertSame(0.1, $hsl->alpha()->toFloat());
        $this->assertSame(150, $hsl2->hue()->toInt());
        $this->assertSame(42, $hsl2->saturation()->toInt());
        $this->assertSame(24, $hsl2->lightness()->toInt());
        $this->assertSame(0.2, $hsl2->alpha()->toFloat());
    }

    public function testSubtractAlpha()
    {
        $hsl = HSLA::from(
            Hue::at(150),
            Saturation::at(42),
            Lightness::at(24),
        );

        $hsl2 = $hsl->subtractAlpha(Alpha::of(0.3)->unwrap());

        $this->assertInstanceOf(HSLA::class, $hsl2);
        $this->assertNotSame($hsl, $hsl2);
        $this->assertSame(150, $hsl->hue()->toInt());
        $this->assertSame(42, $hsl->saturation()->toInt());
        $this->assertSame(24, $hsl->lightness()->toInt());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame(150, $hsl2->hue()->toInt());
        $this->assertSame(42, $hsl2->saturation()->toInt());
        $this->assertSame(24, $hsl2->lightness()->toInt());
        $this->assertSame(0.7, $hsl2->alpha()->toFloat());
    }

    #[DataProvider('withAlpha')]
    public function testWithAlpha(
        string $string,
        int $hue,
        int $saturation,
        int $lightness,
        float $alpha,
    ) {
        $hsla = HSLA::of($string);

        $this->assertInstanceOf(HSLA::class, $hsla);
        $this->assertSame($hue, $hsla->hue()->toInt());
        $this->assertSame($saturation, $hsla->saturation()->toInt());
        $this->assertSame($lightness, $hsla->lightness()->toInt());
        $this->assertSame($alpha, $hsla->alpha()->toFloat());
    }

    public static function withAlpha()
    {
        return [
            ['hsla(10, 20%, 30%, 1.0)', 10, 20, 30, 1.0],
            ['hsla(10, 20%, 30%, 1)', 10, 20, 30, 1.0],
            ['hsla(10, 20%, 30%, 0)', 10, 20, 30, 0.0],
            ['hsla(10, 20%, 30%, 0.0)', 10, 20, 30, 0.0],
            ['hsla(10, 20%, 30%, 0.5)', 10, 20, 30, 0.5],
            ['hsla(30,20%,10%,0.5)', 30, 20, 10, 0.5],
        ];
    }

    #[DataProvider('withoutAlpha')]
    public function testWithoutAlpha(
        string $string,
        int $hue,
        int $saturation,
        int $lightness,
    ) {
        $hsla = HSLA::of($string);

        $this->assertInstanceOf(HSLA::class, $hsla);
        $this->assertSame($hue, $hsla->hue()->toInt());
        $this->assertSame($saturation, $hsla->saturation()->toInt());
        $this->assertSame($lightness, $hsla->lightness()->toInt());
        $this->assertTrue($hsla->alpha()->atMaximum());
    }

    public static function withoutAlpha()
    {
        return [
            ['hsl(10, 20%, 30%)', 10, 20, 30],
            ['hsl(30,20%,10%)', 30, 20, 10],
        ];
    }

    #[DataProvider('colours')]
    public function testOf(
        string $string,
        int $hue,
        int $saturation,
        int $lightness,
        ?float $alpha = null,
    ) {
        $hsla = HSLA::of($string);

        $this->assertInstanceOf(HSLA::class, $hsla);
        $this->assertSame($hue, $hsla->hue()->toInt());
        $this->assertSame($saturation, $hsla->saturation()->toInt());
        $this->assertSame($lightness, $hsla->lightness()->toInt());
        $this->assertSame($alpha ?? 1.0, $hsla->alpha()->toFloat());
    }

    public static function colours()
    {
        return \array_merge(self::withAlpha(), self::withoutAlpha());
    }

    public function testEquals()
    {
        $this->assertTrue(
            HSLA::of('hsl(10, 20%, 30%)')->equals(
                HSLA::of('hsl(10, 20%, 30%)'),
            ),
        );
        $this->assertFalse(
            HSLA::of('hsla(10, 20%, 30%, 0.5)')->equals(
                HSLA::of('hsl(10, 20%, 30%)'),
            ),
        );
    }

    public function testToRGBA()
    {
        $hsla = HSLA::of('hsla(210, 100%, 60%, 0.5)');

        $rgba = $hsla->toRGBA();

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame('3399ff80', $rgba->toHexadecimal());
        $this->assertTrue($rgba->equals($hsla->toRGBA()));

        $hsla = HSLA::of('hsla(210, 0%, 60%, 0.5)');
        $rgba = $hsla->toRGBA();
        $this->assertSame(
            '99999980',
            $rgba->toHexadecimal(),
        );
        $this->assertTrue($rgba->equals($hsla->toRGBA()));
    }

    public function testToCMYKA()
    {
        $hsla = HSLA::of('hsla(210, 100%, 60%, 0.5)');

        $this->assertInstanceOf(CMYKA::class, $hsla->toCMYKA());
        $this->assertTrue($hsla->toCMYKA()->equals($hsla->toRGBA()->toCMYKA()));
    }

    public function testConvertible()
    {
        $hsla = HSLA::of('hsl(0, 0%, 0%)');

        $this->assertSame($hsla, $hsla->toHSLA());
    }
}
