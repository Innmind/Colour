<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour\Colour;

use Innmind\Colour\{
    Colour,
    RGBA,
    HSLA,
    CMYKA
};

class ColourTest extends \PHPUnit_Framework_TestCase
{
    public function testFromString()
    {
        $this->assertInstanceOf(
            RGBA::class,
            Colour::fromString('39F')
        );
        $this->assertInstanceOf(
            HSLA::class,
            Colour::fromString('hsl(0, 0%, 0%)')
        );
        $this->assertInstanceOf(
            CMYKA::class,
            Colour::fromString('device-cmyk(10%, 20%, 30%, 40%)')
        );
    }

    /**
     * @expectedException Innmind\Colour\Exception\InvalidArgumentException
     */
    public function testThrowWhenNoFormatRecognized()
    {
        Colour::fromString('foo');
    }
}
