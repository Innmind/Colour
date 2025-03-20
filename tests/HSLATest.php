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
use PHPUnit\Framework\TestCase;

class HSLATest extends TestCase
{
    public function testInterface()
    {
        $hsl = new HSLA(
            $hue = new Hue(150),
            $saturation = new Saturation(42),
            $lightness = new Lightness(24),
        );

        $this->assertSame($hue, $hsl->hue());
        $this->assertSame($saturation, $hsl->saturation());
        $this->assertSame($lightness, $hsl->lightness());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame('hsl(150, 42%, 24%)', $hsl->toString());

        $hsla = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
            $alpha = new Alpha(0.5),
        );

        $this->assertSame($alpha, $hsla->alpha());
        $this->assertSame('hsla(150, 42%, 24%, 0.5)', $hsla->toString());
    }

    public function testRotateBy()
    {
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
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
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
        );

        $hsl2 = $hsl->addSaturation(new Saturation(58));

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
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
        );

        $hsl2 = $hsl->SubtractSaturation(new Saturation(22));

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
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
        );

        $hsl2 = $hsl->addLightness(new Lightness(6));

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
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
        );

        $hsl2 = $hsl->subtractLightness(new Lightness(22));

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
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
            new Alpha(0.1),
        );

        $hsl2 = $hsl->addALpha(new Alpha(0.1));

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
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
        );

        $hsl2 = $hsl->subtractAlpha(new Alpha(0.3));

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

    /**
     * @dataProvider withAlpha
     */
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

    /**
     * @dataProvider withoutAlpha
     */
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

    /**
     * @dataProvider colours
     */
    public function testOf(
        string $string,
        int $hue,
        int $saturation,
        int $lightness,
        float $alpha = null,
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
