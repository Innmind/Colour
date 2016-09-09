<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidArgumentException;
use Innmind\Immutable\{
    MapInterface,
    Map,
    StringPrimitive as Str
};

final class Colour
{
    private static $literals;

    private function __construct()
    {
    }

    public static function fromString(string $colour): ConvertibleInterface
    {
        try {
            return RGBA::fromString($colour);
        } catch (InvalidArgumentException $e) {
            //attempt next format
        }

        try {
            return HSLA::fromString($colour);
        } catch (InvalidArgumentException $e) {
            //attempt next format
        }

        $literal = (string) (new Str($colour))->trim()->toLower();

        if (self::literals()->contains($literal)) {
            return self::literals()->get($literal);
        }

        return CMYKA::fromString($colour);
    }

    /**
     * @see http://www.w3schools.com/colors/colors_names.asp
     */
    public static function literals(): MapInterface
    {
        if (self::$literals === null) {
            self::$literals = (new Map('string', RGBA::class))
                ->put('aliceblue', RGBA::fromString('f0f8ff'))
                ->put('antiquewhite', RGBA::fromString('faebd7'))
                ->put('aqua', RGBA::fromString('0ff'))
                ->put('aquamarine', RGBA::fromString('7fffd4'))
                ->put('azure', RGBA::fromString('f0ffff'))
                ->put('beige', RGBA::fromString('f5f5dc'))
                ->put('bisque', RGBA::fromString('ffe4c4'))
                ->put('black', RGBA::fromString('000'))
                ->put('blanchedalmond', RGBA::fromString('ffebcd'))
                ->put('blue', RGBA::fromString('00f'))
                ->put('blueviolet', RGBA::fromString('8a2be2'))
                ->put('brown', RGBA::fromString('a52a2a'))
                ->put('burlywood', RGBA::fromString('deb887'))
                ->put('cadetblue', RGBA::fromString('5f9ea0'))
                ->put('chartreuse', RGBA::fromString('7fff00'))
                ->put('chocolate', RGBA::fromString('d2691e'))
                ->put('coral', RGBA::fromString('ff7f50'))
                ->put('cornflowerblue', RGBA::fromString('6495ed'))
                ->put('cornsilk', RGBA::fromString('fff8dc'))
                ->put('crimson', RGBA::fromString('dc143c'))
                ->put('cyan', RGBA::fromString('00ffff'))
                ->put('darkblue', RGBA::fromString('00008b'))
                ->put('darkcyan', RGBA::fromString('008b8b'))
                ->put('darkgoldenrod', RGBA::fromString('b8860b'))
                ->put('darkgray', RGBA::fromString('a9a9a9'))
                ->put('darkgrey', RGBA::fromString('a9a9a9'))
                ->put('darkgreen', RGBA::fromString('006400'))
                ->put('darkkhaki', RGBA::fromString('bdb76b'))
                ->put('darkmagenta', RGBA::fromString('8b008b'))
                ->put('darkolivegreen', RGBA::fromString('556b2f'))
                ->put('darkorange', RGBA::fromString('ff8c00'))
                ->put('darkorchid', RGBA::fromString('9932cc'))
                ->put('darkred', RGBA::fromString('8b0000'))
                ->put('darksalmon', RGBA::fromString('e9967a'))
                ->put('darkseagreen', RGBA::fromString('8fbc8f'))
                ->put('darkslateblue', RGBA::fromString('483d8b'))
                ->put('darkslategray', RGBA::fromString('2f4f4f'))
                ->put('darkslategrey', RGBA::fromString('2f4f4f'))
                ->put('darkturquoise', RGBA::fromString('00ced1'))
                ->put('darkviolet', RGBA::fromString('9400d3'))
                ->put('deeppink', RGBA::fromString('ff1493'))
                ->put('deepskyblue', RGBA::fromString('00bfff'))
                ->put('dimgray', RGBA::fromString('696969'))
                ->put('dimgrey', RGBA::fromString('696969'))
                ->put('dodgerblue', RGBA::fromString('1e90ff'))
                ->put('firebrick', RGBA::fromString('b22222'))
                ->put('floralwhite', RGBA::fromString('fffaf0'))
                ->put('forestgreen', RGBA::fromString('228b22'))
                ->put('fuchsia', RGBA::fromString('ff00ff'))
                ->put('gainsboro', RGBA::fromString('dcdcdc'))
                ->put('ghostwhite', RGBA::fromString('f8f8ff'))
                ->put('gold', RGBA::fromString('ffd700'))
                ->put('goldenrod', RGBA::fromString('daa520'))
                ->put('gray', RGBA::fromString('808080'))
                ->put('grey', RGBA::fromString('808080'))
                ->put('green', RGBA::fromString('008000'))
                ->put('greenyellow', RGBA::fromString('adff2f'))
                ->put('honeydew', RGBA::fromString('f0fff0'))
                ->put('hotpink', RGBA::fromString('ff69b4'))
                ->put('indianred', RGBA::fromString('cd5c5c'))
                ->put('indigo', RGBA::fromString('4b0082'))
                ->put('ivory', RGBA::fromString('fffff0'))
                ->put('khaki', RGBA::fromString('f0e68c'))
                ->put('lavender', RGBA::fromString('e6e6fa'))
                ->put('lavenderblush', RGBA::fromString('fff0f5'))
                ->put('lawngreen', RGBA::fromString('7cfc00'))
                ->put('lemonchiffon', RGBA::fromString('fffacd'))
                ->put('lightblue', RGBA::fromString('add8e6'))
                ->put('lightcoral', RGBA::fromString('f08080'))
                ->put('lightcyan', RGBA::fromString('e0ffff'))
                ->put('lightgoldenrodyellow', RGBA::fromString('fafad2'))
                ->put('lightgray', RGBA::fromString('d3d3d3'))
                ->put('lightgrey', RGBA::fromString('d3d3d3'))
                ->put('lightgreen', RGBA::fromString('90ee90'))
                ->put('lightpink', RGBA::fromString('ffb6c1'))
                ->put('lightsalmon', RGBA::fromString('ffa07a'))
                ->put('lightseagreen', RGBA::fromString('20b2aa'))
                ->put('lightskyblue', RGBA::fromString('87cefa'))
                ->put('lightslategray', RGBA::fromString('778899'))
                ->put('lightslategrey', RGBA::fromString('778899'))
                ->put('lightsteelblue', RGBA::fromString('b0c4de'))
                ->put('lightyellow', RGBA::fromString('ffffe0'))
                ->put('lime', RGBA::fromString('00ff00'))
                ->put('limegreen', RGBA::fromString('32cd32'))
                ->put('linen', RGBA::fromString('faf0e6'))
                ->put('magenta', RGBA::fromString('ff00ff'))
                ->put('maroon', RGBA::fromString('800000'))
                ->put('mediumaquamarine', RGBA::fromString('66cdaa'))
                ->put('mediumblue', RGBA::fromString('0000cd'))
                ->put('mediumorchid', RGBA::fromString('ba55d3'))
                ->put('mediumpurple', RGBA::fromString('9370db'))
                ->put('mediumseagreen', RGBA::fromString('3cb371'))
                ->put('mediumslateblue', RGBA::fromString('7b68ee'))
                ->put('mediumspringgreen', RGBA::fromString('00fa9a'))
                ->put('mediumturquoise', RGBA::fromString('48d1cc'))
                ->put('mediumvioletred', RGBA::fromString('c71585'))
                ->put('midnightblue', RGBA::fromString('191970'))
                ->put('mintcream', RGBA::fromString('f5fffa'))
                ->put('mistyrose', RGBA::fromString('ffe4e1'))
                ->put('moccasin', RGBA::fromString('ffe4b5'))
                ->put('navajowhite', RGBA::fromString('ffdead'))
                ->put('navy', RGBA::fromString('000080'))
                ->put('oldlace', RGBA::fromString('fdf5e6'))
                ->put('olive', RGBA::fromString('808000'))
                ->put('olivedrab', RGBA::fromString('6b8e23'))
                ->put('orange', RGBA::fromString('ffa500'))
                ->put('orangered', RGBA::fromString('ff4500'))
                ->put('orchid', RGBA::fromString('da70d6'))
                ->put('palegoldenrod', RGBA::fromString('eee8aa'))
                ->put('palegreen', RGBA::fromString('98fb98'))
                ->put('paleturquoise', RGBA::fromString('afeeee'))
                ->put('palevioletred', RGBA::fromString('db7093'))
                ->put('papayawhip', RGBA::fromString('ffefd5'))
                ->put('peachpuff', RGBA::fromString('ffdab9'))
                ->put('peru', RGBA::fromString('cd853f'))
                ->put('pink', RGBA::fromString('ffc0cb'))
                ->put('plum', RGBA::fromString('dda0dd'))
                ->put('powderblue', RGBA::fromString('b0e0e6'))
                ->put('purple', RGBA::fromString('800080'))
                ->put('rebeccapurple', RGBA::fromString('663399'))
                ->put('red', RGBA::fromString('ff0000'))
                ->put('rosybrown', RGBA::fromString('bc8f8f'))
                ->put('royalblue', RGBA::fromString('4169e1'))
                ->put('saddlebrown', RGBA::fromString('8b4513'))
                ->put('salmon', RGBA::fromString('fa8072'))
                ->put('sandybrown', RGBA::fromString('f4a460'))
                ->put('seagreen', RGBA::fromString('2e8b57'))
                ->put('seashell', RGBA::fromString('fff5ee'))
                ->put('sienna', RGBA::fromString('a0522d'))
                ->put('silver', RGBA::fromString('c0c0c0'))
                ->put('skyblue', RGBA::fromString('87ceeb'))
                ->put('slateblue', RGBA::fromString('6a5acd'))
                ->put('slategray', RGBA::fromString('708090'))
                ->put('slategrey', RGBA::fromString('708090'))
                ->put('snow', RGBA::fromString('fffafa'))
                ->put('springgreen', RGBA::fromString('00ff7f'))
                ->put('steelblue', RGBA::fromString('4682b4'))
                ->put('tan', RGBA::fromString('d2b48c'))
                ->put('teal', RGBA::fromString('008080'))
                ->put('thistle', RGBA::fromString('d8bfd8'))
                ->put('tomato', RGBA::fromString('ff6347'))
                ->put('turquoise', RGBA::fromString('40e0d0'))
                ->put('violet', RGBA::fromString('ee82ee'))
                ->put('wheat', RGBA::fromString('f5deb3'))
                ->put('white', RGBA::fromString('ffffff'))
                ->put('whitesmoke', RGBA::fromString('f5f5f5'))
                ->put('yellow', RGBA::fromString('ffff00'))
                ->put('yellowgreen', RGBA::fromString('9acd32'));
        }

        return self::$literals;
    }
}
