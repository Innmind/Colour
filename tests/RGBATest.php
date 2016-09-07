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
use Innmind\Immutable\StringPrimitive as Str;

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

    /**
     * @dataProvider hexadecimalWithAlpha
     */
    public function testFromHexadecimalWithAlpha(
        string $string,
        int $red,
        int $green,
        int $blue,
        float $alpha
    ) {
        $rgba = RGBA::fromHexadecimalWithAlpha(
            new Str($string)
        );

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame($red, $rgba->red()->toInt());
        $this->assertSame($blue, $rgba->blue()->toInt());
        $this->assertSame($green, $rgba->green()->toInt());
        $this->assertSame($alpha, $rgba->alpha()->toFloat());
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingFromHexadecimalWithUnfoundAlpha()
    {
        RGBA::fromHexadecimalWithAlpha(
            new Str('#39F')
        );
    }

    public function hexadecimalWithAlpha()
    {
        return [
            ['#39FF', 51, 153, 255, 1.0],
            ['39F0', 51, 153, 255, 0.0],
            ['#3399FFFF', 51, 153, 255, 1.0],
            ['3399FF00', 51, 153, 255, 0.0],
        ];
    }

    /**
     * @dataProvider hexadecimalWithoutAlpha
     */
    public function testFromHexadecimalWithoutAlpha(
        string $string,
        int $red,
        int $green,
        int $blue
    ) {
        $rgba = RGBA::fromHexadecimalWithoutAlpha(
            new Str($string)
        );

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame($red, $rgba->red()->toInt());
        $this->assertSame($blue, $rgba->blue()->toInt());
        $this->assertSame($green, $rgba->green()->toInt());
        $this->assertTrue($rgba->alpha()->atMaximum());
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingFromStringWithFoundAlpha()
    {
        RGBA::fromHexadecimalWithoutAlpha(
            new Str('#39FF')
        );
    }

    public function hexadecimalWithoutAlpha()
    {
        return [
            ['#39F', 51, 153, 255],
            ['39F', 51, 153, 255],
            ['#3399FF', 51, 153, 255],
            ['3399FF', 51, 153, 255],
        ];
    }

    /**
     * @dataProvider hexadecimals
     */
    public function testFromHexadecimal(
        string $string,
        int $red,
        int $green,
        int $blue,
        float $alpha = null
    ) {
        $rgba = RGBA::fromHexadecimal($string);

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame($red, $rgba->red()->toInt());
        $this->assertSame($blue, $rgba->blue()->toInt());
        $this->assertSame($green, $rgba->green()->toInt());
        $this->assertSame($alpha ?? 1.0, $rgba->alpha()->toFloat());
    }

    public function hexadecimals()
    {
        return array_merge($this->hexadecimalWithAlpha(), $this->hexadecimalWithoutAlpha());
    }

    public function testFromRGBFunctionWithPoints()
    {
        $rgb = RGBA::fromRGBFunctionWithPoints(
            new Str('rgb(10, 20, 30)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(10, $rgb->red()->toInt());
        $this->assertSame(20, $rgb->green()->toInt());
        $this->assertSame(30, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidRGBFunctionWithPoints()
    {
        RGBA::fromRGBFunctionWithPoints(
            new Str('rgb(10, 20%, 30)')
        );
    }

    public function testFromRGBFunctionWithPercents()
    {
        $rgb = RGBA::fromRGBFunctionWithPercents(
            new Str('rgb(10%, 20%, 30%)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(26, $rgb->red()->toInt());
        $this->assertSame(51, $rgb->green()->toInt());
        $this->assertSame(77, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidRGBFunctionWithPercents()
    {
        RGBA::fromRGBFunctionWithPercents(
            new Str('rgb(10, 20%, 30)')
        );
    }

    public function testFromRGBFunction()
    {
        $rgb = RGBA::fromRGBFunction('rgb(10, 20, 30)');

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(10, $rgb->red()->toInt());
        $this->assertSame(20, $rgb->green()->toInt());
        $this->assertSame(30, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());

        $rgb = RGBA::fromRGBFunction('rgb(10%, 20%, 30%)');

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(26, $rgb->red()->toInt());
        $this->assertSame(51, $rgb->green()->toInt());
        $this->assertSame(77, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());
    }

    public function testFromRGBAFunctionWithPoints()
    {
        $rgb = RGBA::fromRGBAFunctionWithPoints(
            new Str('rgba(10, 20, 30, 0.5)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(10, $rgb->red()->toInt());
        $this->assertSame(20, $rgb->green()->toInt());
        $this->assertSame(30, $rgb->blue()->toInt());
        $this->assertSame(0.5, $rgb->alpha()->toFloat());
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidRGBAFunctionWithPoints()
    {
        RGBA::fromRGBAFunctionWithPoints(
            new Str('rgba(10, 20%, 30, 2.0)')
        );
    }

    public function testFromRGBAFunctionWithPercents()
    {
        $rgb = RGBA::fromRGBAFunctionWithPercents(
            new Str('rgba(10%, 20%, 30%, 0)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(26, $rgb->red()->toInt());
        $this->assertSame(51, $rgb->green()->toInt());
        $this->assertSame(77, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMinimum());
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidRGBAFunctionWithPercents()
    {
        RGBA::fromRGBFunctionWithPercents(
            new Str('rgba(10, 20%, 30, 1)')
        );
    }

    public function testFromRGBAFunction()
    {
        $rgb = RGBA::fromRGBAFunction('rgba(10, 20, 30, 1)');

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(10, $rgb->red()->toInt());
        $this->assertSame(20, $rgb->green()->toInt());
        $this->assertSame(30, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());

        $rgb = RGBA::fromRGBAFunction('rgba(10%, 20%, 30%, 1.0)');

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(26, $rgb->red()->toInt());
        $this->assertSame(51, $rgb->green()->toInt());
        $this->assertSame(77, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());
    }

    /**
     * @dataProvider allFormats
     */
    public function testFromString(
        string $colour,
        int $red,
        int $green,
        int $blue,
        float $alpha
    ) {
        $rgba = RGBA::fromString($colour);

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame($red, $rgba->red()->toInt());
        $this->assertSame($green, $rgba->green()->toInt());
        $this->assertSame($blue, $rgba->blue()->toInt());
        $this->assertSame($alpha, round($rgba->alpha()->toFloat(), 1));
    }

    public function allFormats()
    {
        return [
            ['#39F', 51, 153, 255, 1.0],
            ['#3399FF', 51, 153, 255, 1.0],
            ['#39F8', 51, 153, 255, 0.5],
            ['#3399FF80', 51, 153, 255, 0.5],
            ['39F', 51, 153, 255, 1.0],
            ['3399FF', 51, 153, 255, 1.0],
            ['39F8', 51, 153, 255, 0.5],
            ['3399FF80', 51, 153, 255, 0.5],
            ['rgb(51, 153, 255)', 51, 153, 255, 1.0],
            ['rgb(51,153,255)', 51, 153, 255, 1.0],
            ['rgb(20%, 60%, 100%)', 51, 153, 255, 1.0],
            ['rgb(20%,60%,100%)', 51, 153, 255, 1.0],
            ['rgba(51, 153, 255, 0.5)', 51, 153, 255, 0.5],
            ['rgba(51,153,255,0.5)', 51, 153, 255, 0.5],
            ['rgba(20%, 60%, 100%, 0.5)', 51, 153, 255, 0.5],
            ['rgba(20%,60%,100%,0.5)', 51, 153, 255, 0.5],
        ];
    }
}
