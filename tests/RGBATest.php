<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Red,
    Blue,
    Green,
    Alpha,
    RGBA
};

class RGBATest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $rgba = new RGBA(
            $red = new Red(0),
            $green = new Green(255),
            $blue = new Blue(122),
            $alpha = new Alpha(0.5)
        );

        $this->assertSame($red, $rgba->red());
        $this->assertSame($blue, $rgba->blue());
        $this->assertSame($green, $rgba->green());
        $this->assertSame($alpha, $rgba->alpha());
        $this->assertSame('rgba(0, 255, 122, 0.5)', (string) $rgba);
    }

    public function testWithoutAlpha()
    {
        $rgba = new RGBA(
            new Red(0),
            new Green(255),
            new Blue(122)
        );

        $this->assertSame(1.0, $rgba->alpha()->toFloat());
    }

    public function testStringCast()
    {
        $rgba = new RGBA(
            new Red(0),
            new Green(255),
            new Blue(122)
        );

        $this->assertSame('#00ff7a', (string) $rgba);
        $this->assertSame(
            'rgba(0, 255, 122, 0.5)',
            (string) $rgba->subtractAlpha(new Alpha(0.5))
        );
    }

    public function testToHexadecimal()
    {
        $rgba = new RGBA(
            new Red(0),
            new Green(255),
            new Blue(122)
        );

        $this->assertSame(
            '00ff7a',
            $rgba->toHexadecimal()
        );
        $this->assertSame(
            '00ff7a80',
            $rgba->subtractAlpha(new Alpha(0.5))->toHexadecimal()
        );
    }

    public function testAddRed()
    {
        $rgba = new RGBA(
            new Red(10),
            new Green(255),
            new Blue(122),
            new Alpha(0.5)
        );

        $rgba2 = $rgba->addRed(new Red(150));
        $this->assertInstanceOf(RGBA::class, $rgba2);
        $this->assertNotSame($rgba, $rgba2);
        $this->assertSame(10, $rgba->red()->toInt());
        $this->assertSame(122, $rgba->blue()->toInt());
        $this->assertSame(255, $rgba->green()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertSame(160, $rgba2->red()->toInt());
        $this->assertSame(122, $rgba2->blue()->toInt());
        $this->assertSame(255, $rgba2->green()->toInt());
        $this->assertSame(0.5, $rgba2->alpha()->toFloat());
    }

    public function testSubtractRed()
    {
        $rgba = new RGBA(
            new Red(150),
            new Green(255),
            new Blue(122),
            new Alpha(0.5)
        );

        $rgba2 = $rgba->subtractRed(new Red(10));
        $this->assertInstanceOf(RGBA::class, $rgba2);
        $this->assertNotSame($rgba, $rgba2);
        $this->assertSame(150, $rgba->red()->toInt());
        $this->assertSame(122, $rgba->blue()->toInt());
        $this->assertSame(255, $rgba->green()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertSame(140, $rgba2->red()->toInt());
        $this->assertSame(122, $rgba2->blue()->toInt());
        $this->assertSame(255, $rgba2->green()->toInt());
        $this->assertSame(0.5, $rgba2->alpha()->toFloat());
    }

    public function testAddBlue()
    {
        $rgba = new RGBA(
            new Red(10),
            new Green(255),
            new Blue(122),
            new Alpha(0.5)
        );

        $rgba2 = $rgba->addBlue(new Blue(12));
        $this->assertInstanceOf(RGBA::class, $rgba2);
        $this->assertNotSame($rgba, $rgba2);
        $this->assertSame(10, $rgba->red()->toInt());
        $this->assertSame(122, $rgba->blue()->toInt());
        $this->assertSame(255, $rgba->green()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertSame(10, $rgba2->red()->toInt());
        $this->assertSame(134, $rgba2->blue()->toInt());
        $this->assertSame(255, $rgba2->green()->toInt());
        $this->assertSame(0.5, $rgba2->alpha()->toFloat());
    }

    public function testSubtractBlue()
    {
        $rgba = new RGBA(
            new Red(10),
            new Green(255),
            new Blue(122),
            new Alpha(0.5)
        );

        $rgba2 = $rgba->subtractBlue(new Blue(10));
        $this->assertInstanceOf(RGBA::class, $rgba2);
        $this->assertNotSame($rgba, $rgba2);
        $this->assertSame(10, $rgba->red()->toInt());
        $this->assertSame(122, $rgba->blue()->toInt());
        $this->assertSame(255, $rgba->green()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertSame(10, $rgba2->red()->toInt());
        $this->assertSame(112, $rgba2->blue()->toInt());
        $this->assertSame(255, $rgba2->green()->toInt());
        $this->assertSame(0.5, $rgba2->alpha()->toFloat());
    }

    public function testAddGreen()
    {
        $rgba = new RGBA(
            new Red(10),
            new Green(205),
            new Blue(122),
            new Alpha(0.5)
        );

        $rgba2 = $rgba->addGreen(new Green(15));
        $this->assertInstanceOf(RGBA::class, $rgba2);
        $this->assertNotSame($rgba, $rgba2);
        $this->assertSame(10, $rgba->red()->toInt());
        $this->assertSame(122, $rgba->blue()->toInt());
        $this->assertSame(205, $rgba->green()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertSame(10, $rgba2->red()->toInt());
        $this->assertSame(122, $rgba2->blue()->toInt());
        $this->assertSame(220, $rgba2->green()->toInt());
        $this->assertSame(0.5, $rgba2->alpha()->toFloat());
    }

    public function testSubtractGreen()
    {
        $rgba = new RGBA(
            new Red(10),
            new Green(255),
            new Blue(122),
            new Alpha(0.5)
        );

        $rgba2 = $rgba->subtractGreen(new Green(10));
        $this->assertInstanceOf(RGBA::class, $rgba2);
        $this->assertNotSame($rgba, $rgba2);
        $this->assertSame(10, $rgba->red()->toInt());
        $this->assertSame(122, $rgba->blue()->toInt());
        $this->assertSame(255, $rgba->green()->toInt());
        $this->assertSame(0.5, $rgba->alpha()->toFloat());
        $this->assertSame(10, $rgba2->red()->toInt());
        $this->assertSame(122, $rgba2->blue()->toInt());
        $this->assertSame(245, $rgba2->green()->toInt());
        $this->assertSame(0.5, $rgba2->alpha()->toFloat());
    }
}
