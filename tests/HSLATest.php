<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    HSLA,
    Hue,
    Saturation,
    Lightness,
    Alpha
};

class HSLATest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $hsl = new HSLA(
            $hue = new Hue(150),
            $saturation = new Saturation(42),
            $lightness = new Lightness(24)
        );

        $this->assertSame($hue, $hsl->hue());
        $this->assertSame($saturation, $hsl->saturation());
        $this->assertSame($lightness, $hsl->lightness());
        $this->assertSame(1.0, $hsl->alpha()->toFloat());
        $this->assertSame('hsl(150, 42%, 24%)', (string) $hsl);

        $hsla = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24),
            $alpha = new Alpha(0.5)
        );

        $this->assertSame($alpha, $hsla->alpha());
        $this->assertSame('hsla(150, 42%, 24%, 0.5)', (string) $hsla);
    }

    public function testRotateBy()
    {
        $hsl = new HSLA(
            new Hue(150),
            new Saturation(42),
            new Lightness(24)
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
            new Lightness(24)
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
            new Lightness(24)
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
            new Lightness(24)
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
            new Lightness(24)
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
            new Alpha(0.1)
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
            new Lightness(24)
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
}
