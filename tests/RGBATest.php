<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Red,
    Blue,
    Green,
    Alpha,
    RGBA,
    HSLA,
    CMYKA,
    Convertible,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class RGBATest extends TestCase
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
        $this->assertSame('rgba(0, 255, 122, 0.5)', $rgba->toString());
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

        $this->assertSame('#00ff7a', $rgba->toString());
        $this->assertSame(
            'rgba(0, 255, 122, 0.5)',
            $rgba->subtractAlpha(new Alpha(0.5))->toString()
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
            Str::of($string)
        );

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame($red, $rgba->red()->toInt());
        $this->assertSame($blue, $rgba->blue()->toInt());
        $this->assertSame($green, $rgba->green()->toInt());
        $this->assertSame($alpha, $rgba->alpha()->toFloat());
    }

    public function testThrowWhenBuildingFromHexadecimalWithUnfoundAlpha()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('#39F');

        RGBA::fromHexadecimalWithAlpha(
            Str::of('#39F')
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
        int $blue,
        string $hexa
    ) {
        $rgba = RGBA::fromHexadecimalWithoutAlpha(
            Str::of($string)
        );

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame($red, $rgba->red()->toInt());
        $this->assertSame($blue, $rgba->blue()->toInt());
        $this->assertSame($green, $rgba->green()->toInt());
        $this->assertTrue($rgba->alpha()->atMaximum());
        $this->assertSame($hexa, $rgba->toHexadecimal());
    }

    public function testThrowWhenBuildingFromStringWithFoundAlpha()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('39FF');

        RGBA::fromHexadecimalWithoutAlpha(
            Str::of('#39FF')
        );
    }

    public function hexadecimalWithoutAlpha()
    {
        return [
            ['#39F', 51, 153, 255, '3399ff'],
            ['39F', 51, 153, 255, '3399ff'],
            ['#3399FF', 51, 153, 255, '3399ff'],
            ['3399FF', 51, 153, 255, '3399ff'],
            ['b8860b', 184, 134, 11, 'b8860b'],
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
        $withoutAlpha = array_map(
            function ($value) {
                array_pop($value);

                return $value;
            },
            $this->hexadecimalWithoutAlpha()
        );

        return array_merge($this->hexadecimalWithAlpha(), $withoutAlpha);
    }

    public function testFromRGBFunctionWithPoints()
    {
        $rgb = RGBA::fromRGBFunctionWithPoints(
            Str::of('rgb(10, 20, 30)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(10, $rgb->red()->toInt());
        $this->assertSame(20, $rgb->green()->toInt());
        $this->assertSame(30, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());
    }

    public function testThrowWhenInvalidRGBFunctionWithPoints()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('rgb(10, 20%, 30)');

        RGBA::fromRGBFunctionWithPoints(
            Str::of('rgb(10, 20%, 30)')
        );
    }

    public function testFromRGBFunctionWithPercents()
    {
        $rgb = RGBA::fromRGBFunctionWithPercents(
            Str::of('rgb(10%, 20%, 30%)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(26, $rgb->red()->toInt());
        $this->assertSame(51, $rgb->green()->toInt());
        $this->assertSame(77, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMaximum());
    }

    public function testThrowWhenInvalidRGBFunctionWithPercents()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('rgb(10, 20%, 30)');

        RGBA::fromRGBFunctionWithPercents(
            Str::of('rgb(10, 20%, 30)')
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
            Str::of('rgba(10, 20, 30, 0.5)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(10, $rgb->red()->toInt());
        $this->assertSame(20, $rgb->green()->toInt());
        $this->assertSame(30, $rgb->blue()->toInt());
        $this->assertSame(0.5, $rgb->alpha()->toFloat());
    }

    public function testThrowWhenInvalidRGBAFunctionWithPoints()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('rgba(10, 20%, 30, 2.0)');

        RGBA::fromRGBAFunctionWithPoints(
            Str::of('rgba(10, 20%, 30, 2.0)')
        );
    }

    public function testFromRGBAFunctionWithPercents()
    {
        $rgb = RGBA::fromRGBAFunctionWithPercents(
            Str::of('rgba(10%, 20%, 30%, 0)')
        );

        $this->assertInstanceOf(RGBA::class, $rgb);
        $this->assertSame(26, $rgb->red()->toInt());
        $this->assertSame(51, $rgb->green()->toInt());
        $this->assertSame(77, $rgb->blue()->toInt());
        $this->assertTrue($rgb->alpha()->atMinimum());
    }

    public function testThrowWhenInvalidRGBAFunctionWithPercents()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('rgba(10, 20%, 30, 1)');

        RGBA::fromRGBFunctionWithPercents(
            Str::of('rgba(10, 20%, 30, 1)')
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
    public function testOf(
        string $colour,
        int $red,
        int $green,
        int $blue,
        float $alpha
    ) {
        $rgba = RGBA::of($colour);

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

    public function testToHSLA()
    {
        $hsla = ($rgba = RGBA::of('3399FF80'))->toHSLA();

        $this->assertInstanceOf(HSLA::class, $hsla);
        $this->assertSame(210, $hsla->hue()->toInt());
        $this->assertSame(100, $hsla->saturation()->toInt());
        $this->assertSame(60, $hsla->lightness()->toInt());
        $this->assertSame(0.5, $hsla->alpha()->toFloat());
        $this->assertSame($hsla, $rgba->toHSLA());

        $white = ($rgba = RGBA::of('fff'))->toHSLA();

        $this->assertInstanceOf(HSLA::class, $white);
        $this->assertSame(0, $white->hue()->toInt());
        $this->assertSame(0, $white->saturation()->toInt());
        $this->assertSame(100, $white->lightness()->toInt());
        $this->assertSame(1.0, $white->alpha()->toFloat());
        $this->assertSame($white, $rgba->toHSLA());

        $black = ($rgba = RGBA::of('000'))->toHSLA();

        $this->assertInstanceOf(HSLA::class, $black);
        $this->assertSame(0, $black->hue()->toInt());
        $this->assertSame(0, $black->saturation()->toInt());
        $this->assertSame(0, $black->lightness()->toInt());
        $this->assertSame(1.0, $black->alpha()->toFloat());
        $this->assertSame($black, $rgba->toHSLA());
    }

    public function testToCMYKA()
    {
        $cmyka = ($rgba = RGBA::of('3399FF80'))->toCMYKA();

        $this->assertInstanceOf(CMYKA::class, $cmyka);
        $this->assertSame(80, $cmyka->cyan()->toInt());
        $this->assertSame(40, $cmyka->magenta()->toInt());
        $this->assertSame(0, $cmyka->yellow()->toInt());
        $this->assertSame(0, $cmyka->black()->toInt());
        $this->assertSame(0.5, $cmyka->alpha()->toFloat());
        $this->assertSame($cmyka, $rgba->toCMYKA());

        $black = ($rgba = RGBA::of('00000080'))->toCMYKA();

        $this->assertInstanceOf(CMYKA::class, $black);
        $this->assertSame(0, $black->cyan()->toInt());
        $this->assertSame(0, $black->magenta()->toInt());
        $this->assertSame(0, $black->yellow()->toInt());
        $this->assertSame(100, $black->black()->toInt());
        $this->assertSame(0.5, $black->alpha()->toFloat());
        $this->assertSame($black, $rgba->toCMYKA());
    }

    public function testEquals()
    {
        $this->assertTrue(
            RGBA::of('39F')->equals(
                RGBA::of('39F')
            )
        );
        $this->assertFalse(
            RGBA::of('39F8')->equals(
                RGBA::of('39F')
            )
        );
    }

    public function testConvertible()
    {
        $rgba = RGBA::of('39F');

        $this->assertInstanceOf(Convertible::class, $rgba);
        $this->assertSame($rgba, $rgba->toRGBA());
    }
}
