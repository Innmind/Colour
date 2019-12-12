<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\DomainException;
use Innmind\Immutable\{
    MapInterface,
    Map,
    Str
};

final class Colour
{
    private static $literals;

    private function __construct()
    {
    }

    public static function of(string $colour): Convertible
    {
        try {
            return RGBA::of($colour);
        } catch (DomainException $e) {
            //attempt next format
        }

        try {
            return HSLA::of($colour);
        } catch (DomainException $e) {
            //attempt next format
        }

        $literal = (string) (new Str($colour))->trim()->toLower();

        if (self::literals()->contains($literal)) {
            return self::literals()->get($literal);
        }

        return CMYKA::of($colour);
    }

    /**
     * @see http://www.w3schools.com/colors/colors_names.asp
     */
    public static function literals(): MapInterface
    {
        if (self::$literals === null) {
            self::$literals = (new Map('string', RGBA::class))
                ->put('aliceblue', RGBA::of('f0f8ff'))
                ->put('antiquewhite', RGBA::of('faebd7'))
                ->put('aqua', RGBA::of('0ff'))
                ->put('aquamarine', RGBA::of('7fffd4'))
                ->put('azure', RGBA::of('f0ffff'))
                ->put('beige', RGBA::of('f5f5dc'))
                ->put('bisque', RGBA::of('ffe4c4'))
                ->put('black', RGBA::of('000'))
                ->put('blanchedalmond', RGBA::of('ffebcd'))
                ->put('blue', RGBA::of('00f'))
                ->put('blueviolet', RGBA::of('8a2be2'))
                ->put('brown', RGBA::of('a52a2a'))
                ->put('burlywood', RGBA::of('deb887'))
                ->put('cadetblue', RGBA::of('5f9ea0'))
                ->put('chartreuse', RGBA::of('7fff00'))
                ->put('chocolate', RGBA::of('d2691e'))
                ->put('coral', RGBA::of('ff7f50'))
                ->put('cornflowerblue', RGBA::of('6495ed'))
                ->put('cornsilk', RGBA::of('fff8dc'))
                ->put('crimson', RGBA::of('dc143c'))
                ->put('cyan', RGBA::of('00ffff'))
                ->put('darkblue', RGBA::of('00008b'))
                ->put('darkcyan', RGBA::of('008b8b'))
                ->put('darkgoldenrod', RGBA::of('b8860b'))
                ->put('darkgray', RGBA::of('a9a9a9'))
                ->put('darkgrey', RGBA::of('a9a9a9'))
                ->put('darkgreen', RGBA::of('006400'))
                ->put('darkkhaki', RGBA::of('bdb76b'))
                ->put('darkmagenta', RGBA::of('8b008b'))
                ->put('darkolivegreen', RGBA::of('556b2f'))
                ->put('darkorange', RGBA::of('ff8c00'))
                ->put('darkorchid', RGBA::of('9932cc'))
                ->put('darkred', RGBA::of('8b0000'))
                ->put('darksalmon', RGBA::of('e9967a'))
                ->put('darkseagreen', RGBA::of('8fbc8f'))
                ->put('darkslateblue', RGBA::of('483d8b'))
                ->put('darkslategray', RGBA::of('2f4f4f'))
                ->put('darkslategrey', RGBA::of('2f4f4f'))
                ->put('darkturquoise', RGBA::of('00ced1'))
                ->put('darkviolet', RGBA::of('9400d3'))
                ->put('deeppink', RGBA::of('ff1493'))
                ->put('deepskyblue', RGBA::of('00bfff'))
                ->put('dimgray', RGBA::of('696969'))
                ->put('dimgrey', RGBA::of('696969'))
                ->put('dodgerblue', RGBA::of('1e90ff'))
                ->put('firebrick', RGBA::of('b22222'))
                ->put('floralwhite', RGBA::of('fffaf0'))
                ->put('forestgreen', RGBA::of('228b22'))
                ->put('fuchsia', RGBA::of('ff00ff'))
                ->put('gainsboro', RGBA::of('dcdcdc'))
                ->put('ghostwhite', RGBA::of('f8f8ff'))
                ->put('gold', RGBA::of('ffd700'))
                ->put('goldenrod', RGBA::of('daa520'))
                ->put('gray', RGBA::of('808080'))
                ->put('grey', RGBA::of('808080'))
                ->put('green', RGBA::of('008000'))
                ->put('greenyellow', RGBA::of('adff2f'))
                ->put('honeydew', RGBA::of('f0fff0'))
                ->put('hotpink', RGBA::of('ff69b4'))
                ->put('indianred', RGBA::of('cd5c5c'))
                ->put('indigo', RGBA::of('4b0082'))
                ->put('ivory', RGBA::of('fffff0'))
                ->put('khaki', RGBA::of('f0e68c'))
                ->put('lavender', RGBA::of('e6e6fa'))
                ->put('lavenderblush', RGBA::of('fff0f5'))
                ->put('lawngreen', RGBA::of('7cfc00'))
                ->put('lemonchiffon', RGBA::of('fffacd'))
                ->put('lightblue', RGBA::of('add8e6'))
                ->put('lightcoral', RGBA::of('f08080'))
                ->put('lightcyan', RGBA::of('e0ffff'))
                ->put('lightgoldenrodyellow', RGBA::of('fafad2'))
                ->put('lightgray', RGBA::of('d3d3d3'))
                ->put('lightgrey', RGBA::of('d3d3d3'))
                ->put('lightgreen', RGBA::of('90ee90'))
                ->put('lightpink', RGBA::of('ffb6c1'))
                ->put('lightsalmon', RGBA::of('ffa07a'))
                ->put('lightseagreen', RGBA::of('20b2aa'))
                ->put('lightskyblue', RGBA::of('87cefa'))
                ->put('lightslategray', RGBA::of('778899'))
                ->put('lightslategrey', RGBA::of('778899'))
                ->put('lightsteelblue', RGBA::of('b0c4de'))
                ->put('lightyellow', RGBA::of('ffffe0'))
                ->put('lime', RGBA::of('00ff00'))
                ->put('limegreen', RGBA::of('32cd32'))
                ->put('linen', RGBA::of('faf0e6'))
                ->put('magenta', RGBA::of('ff00ff'))
                ->put('maroon', RGBA::of('800000'))
                ->put('mediumaquamarine', RGBA::of('66cdaa'))
                ->put('mediumblue', RGBA::of('0000cd'))
                ->put('mediumorchid', RGBA::of('ba55d3'))
                ->put('mediumpurple', RGBA::of('9370db'))
                ->put('mediumseagreen', RGBA::of('3cb371'))
                ->put('mediumslateblue', RGBA::of('7b68ee'))
                ->put('mediumspringgreen', RGBA::of('00fa9a'))
                ->put('mediumturquoise', RGBA::of('48d1cc'))
                ->put('mediumvioletred', RGBA::of('c71585'))
                ->put('midnightblue', RGBA::of('191970'))
                ->put('mintcream', RGBA::of('f5fffa'))
                ->put('mistyrose', RGBA::of('ffe4e1'))
                ->put('moccasin', RGBA::of('ffe4b5'))
                ->put('navajowhite', RGBA::of('ffdead'))
                ->put('navy', RGBA::of('000080'))
                ->put('oldlace', RGBA::of('fdf5e6'))
                ->put('olive', RGBA::of('808000'))
                ->put('olivedrab', RGBA::of('6b8e23'))
                ->put('orange', RGBA::of('ffa500'))
                ->put('orangered', RGBA::of('ff4500'))
                ->put('orchid', RGBA::of('da70d6'))
                ->put('palegoldenrod', RGBA::of('eee8aa'))
                ->put('palegreen', RGBA::of('98fb98'))
                ->put('paleturquoise', RGBA::of('afeeee'))
                ->put('palevioletred', RGBA::of('db7093'))
                ->put('papayawhip', RGBA::of('ffefd5'))
                ->put('peachpuff', RGBA::of('ffdab9'))
                ->put('peru', RGBA::of('cd853f'))
                ->put('pink', RGBA::of('ffc0cb'))
                ->put('plum', RGBA::of('dda0dd'))
                ->put('powderblue', RGBA::of('b0e0e6'))
                ->put('purple', RGBA::of('800080'))
                ->put('rebeccapurple', RGBA::of('663399'))
                ->put('red', RGBA::of('ff0000'))
                ->put('rosybrown', RGBA::of('bc8f8f'))
                ->put('royalblue', RGBA::of('4169e1'))
                ->put('saddlebrown', RGBA::of('8b4513'))
                ->put('salmon', RGBA::of('fa8072'))
                ->put('sandybrown', RGBA::of('f4a460'))
                ->put('seagreen', RGBA::of('2e8b57'))
                ->put('seashell', RGBA::of('fff5ee'))
                ->put('sienna', RGBA::of('a0522d'))
                ->put('silver', RGBA::of('c0c0c0'))
                ->put('skyblue', RGBA::of('87ceeb'))
                ->put('slateblue', RGBA::of('6a5acd'))
                ->put('slategray', RGBA::of('708090'))
                ->put('slategrey', RGBA::of('708090'))
                ->put('snow', RGBA::of('fffafa'))
                ->put('springgreen', RGBA::of('00ff7f'))
                ->put('steelblue', RGBA::of('4682b4'))
                ->put('tan', RGBA::of('d2b48c'))
                ->put('teal', RGBA::of('008080'))
                ->put('thistle', RGBA::of('d8bfd8'))
                ->put('tomato', RGBA::of('ff6347'))
                ->put('turquoise', RGBA::of('40e0d0'))
                ->put('violet', RGBA::of('ee82ee'))
                ->put('wheat', RGBA::of('f5deb3'))
                ->put('white', RGBA::of('ffffff'))
                ->put('whitesmoke', RGBA::of('f5f5f5'))
                ->put('yellow', RGBA::of('ffff00'))
                ->put('yellowgreen', RGBA::of('9acd32'));
        }

        return self::$literals;
    }
}
