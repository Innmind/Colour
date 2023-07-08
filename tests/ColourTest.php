<?php
declare(strict_types = 1);

namespace Tests\Innmind\Colour;

use Innmind\Colour\{
    Colour,
    RGBA,
    HSLA,
    CMYKA,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};

class ColourTest extends TestCase
{
    use BlackBox;

    public function testOf()
    {
        $this->assertInstanceOf(
            RGBA::class,
            Colour::of('39F'),
        );
        $this->assertInstanceOf(
            HSLA::class,
            Colour::of('hsl(0, 0%, 0%)'),
        );
        $this->assertInstanceOf(
            CMYKA::class,
            Colour::of('device-cmyk(10%, 20%, 30%, 40%)'),
        );
    }

    public function testReturnNothingForRandomStrings()
    {
        $this
            ->forAll(Set\Unicode::strings())
            ->then(function($string) {
                $this->assertNull(Colour::maybe($string)->match(
                    static fn($colour) => $colour,
                    static fn() => null,
                ));
            });
    }

    public function testThrowWhenNoFormatRecognized()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        Colour::of('foo');
    }

    public function testLiterals()
    {
        $this->assertCount(98, Colour::cases());
    }

    /**
     * @dataProvider literals
     */
    public function testFromLiteral(Colour|RGBA $colour, string $hex)
    {
        $rgba = $colour->toRGBA();

        $this->assertInstanceOf(RGBA::class, $rgba);
        $this->assertSame($hex, $rgba->toHexadecimal());
    }

    public static function literals()
    {
        return [
            [Colour::aliceblue, 'f0f8ff'],
            [Colour::antiquewhite, 'faebd7'],
            [Colour::aqua, '00ffff'],
            [Colour::aquamarine, '7fffd4'],
            [Colour::azure, 'f0ffff'],
            [Colour::beige, 'f5f5dc'],
            [Colour::bisque, 'ffe4c4'],
            [Colour::black, '000000'],
            [Colour::blanchedalmond, 'ffebcd'],
            [Colour::blue, '0000ff'],
            [Colour::blueviolet, '8a2be2'],
            [Colour::brown, 'a52a2a'],
            [Colour::burlywood, 'deb887'],
            [Colour::cadetblue, '5f9ea0'],
            [Colour::chartreuse, '7fff00'],
            [Colour::chocolate, 'd2691e'],
            [Colour::coral, 'ff7f50'],
            [Colour::cornflowerblue, '6495ed'],
            [Colour::cornsilk, 'fff8dc'],
            [Colour::crimson, 'dc143c'],
            [Colour::cyan, '00ffff'],
            [Colour::blue->dark(), '00008b'],
            [Colour::cyan->dark(), '008b8b'],
            [Colour::goldenrod->dark(), 'b8860b'],
            [Colour::grey->dark(), 'a9a9a9'],
            [Colour::green->dark(), '006400'],
            [Colour::khaki->dark(), 'bdb76b'],
            [Colour::magenta->dark(), '8b008b'],
            [Colour::orange->dark(), 'ff8c00'],
            [Colour::orchid->dark(), '9932cc'],
            [Colour::red->dark(), '8b0000'],
            [Colour::salmon->dark(), 'e9967a'],
            [Colour::seagreen->dark(), '8fbc8f'],
            [Colour::slateblue->dark(), '483d8b'],
            [Colour::slategrey->dark(), '2f4f4f'],
            [Colour::turquoise->dark(), '00ced1'],
            [Colour::violet->dark(), '9400d3'],
            [Colour::deeppink, 'ff1493'],
            [Colour::deepskyblue, '00bfff'],
            [Colour::dimgrey, '696969'],
            [Colour::dodgerblue, '1e90ff'],
            [Colour::firebrick, 'b22222'],
            [Colour::floralwhite, 'fffaf0'],
            [Colour::forestgreen, '228b22'],
            [Colour::fuchsia, 'ff00ff'],
            [Colour::gainsboro, 'dcdcdc'],
            [Colour::ghostwhite, 'f8f8ff'],
            [Colour::gold, 'ffd700'],
            [Colour::goldenrod, 'daa520'],
            [Colour::grey, '808080'],
            [Colour::green, '008000'],
            [Colour::greenyellow, 'adff2f'],
            [Colour::honeydew, 'f0fff0'],
            [Colour::hotpink, 'ff69b4'],
            [Colour::indianred, 'cd5c5c'],
            [Colour::indigo, '4b0082'],
            [Colour::ivory, 'fffff0'],
            [Colour::khaki, 'f0e68c'],
            [Colour::lavender, 'e6e6fa'],
            [Colour::lavenderblush, 'fff0f5'],
            [Colour::lawngreen, '7cfc00'],
            [Colour::lemonchiffon, 'fffacd'],
            [Colour::blue->light(), 'add8e6'],
            [Colour::coral->light(), 'f08080'],
            [Colour::cyan->light(), 'e0ffff'],
            [Colour::grey->light(), 'd3d3d3'],
            [Colour::green->light(), '90ee90'],
            [Colour::pink->light(), 'ffb6c1'],
            [Colour::salmon->light(), 'ffa07a'],
            [Colour::seagreen->light(), '20b2aa'],
            [Colour::skyblue->light(), '87cefa'],
            [Colour::slategrey->light(), '778899'],
            [Colour::steelblue->light(), 'b0c4de'],
            [Colour::yellow->light(), 'ffffe0'],
            [Colour::lime, '00ff00'],
            [Colour::limegreen, '32cd32'],
            [Colour::linen, 'faf0e6'],
            [Colour::magenta, 'ff00ff'],
            [Colour::maroon, '800000'],
            [Colour::aquamarine->medium(), '66cdaa'],
            [Colour::blue->medium(), '0000cd'],
            [Colour::orchid->medium(), 'ba55d3'],
            [Colour::purple->medium(), '9370db'],
            [Colour::seagreen->medium(), '3cb371'],
            [Colour::slateblue->medium(), '7b68ee'],
            [Colour::springgreen->medium(), '00fa9a'],
            [Colour::turquoise->medium(), '48d1cc'],
            [Colour::midnightblue, '191970'],
            [Colour::mintcream, 'f5fffa'],
            [Colour::mistyrose, 'ffe4e1'],
            [Colour::moccasin, 'ffe4b5'],
            [Colour::navajowhite, 'ffdead'],
            [Colour::navy, '000080'],
            [Colour::oldlace, 'fdf5e6'],
            [Colour::olive, '808000'],
            [Colour::olivedrab, '6b8e23'],
            [Colour::orange, 'ffa500'],
            [Colour::orangered, 'ff4500'],
            [Colour::orchid, 'da70d6'],
            [Colour::goldenrod->pale(), 'eee8aa'],
            [Colour::green->pale(), '98fb98'],
            [Colour::turquoise->pale(), 'afeeee'],
            [Colour::papayawhip, 'ffefd5'],
            [Colour::peachpuff, 'ffdab9'],
            [Colour::peru, 'cd853f'],
            [Colour::pink, 'ffc0cb'],
            [Colour::plum, 'dda0dd'],
            [Colour::powderblue, 'b0e0e6'],
            [Colour::purple, '800080'],
            [Colour::rebeccapurple, '663399'],
            [Colour::red, 'ff0000'],
            [Colour::rosybrown, 'bc8f8f'],
            [Colour::royalblue, '4169e1'],
            [Colour::saddlebrown, '8b4513'],
            [Colour::salmon, 'fa8072'],
            [Colour::sandybrown, 'f4a460'],
            [Colour::seagreen, '2e8b57'],
            [Colour::seashell, 'fff5ee'],
            [Colour::sienna, 'a0522d'],
            [Colour::silver, 'c0c0c0'],
            [Colour::skyblue, '87ceeb'],
            [Colour::slateblue, '6a5acd'],
            [Colour::slategrey, '708090'],
            [Colour::snow, 'fffafa'],
            [Colour::springgreen, '00ff7f'],
            [Colour::steelblue, '4682b4'],
            [Colour::tan, 'd2b48c'],
            [Colour::teal, '008080'],
            [Colour::thistle, 'd8bfd8'],
            [Colour::tomato, 'ff6347'],
            [Colour::turquoise, '40e0d0'],
            [Colour::violet, 'ee82ee'],
            [Colour::wheat, 'f5deb3'],
            [Colour::white, 'ffffff'],
            [Colour::whitesmoke, 'f5f5f5'],
            [Colour::yellow, 'ffff00'],
            [Colour::yellowgreen, '9acd32'],
        ];
    }
}
