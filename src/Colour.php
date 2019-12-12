<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\DomainException;
use Innmind\Immutable\{
    Map,
    Str,
};

final class Colour
{
    private static Map $literals;

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

        $literal = Str::of($colour)->trim()->toLower()->toString();

        if (self::literals()->contains($literal)) {
            return self::literals()->get($literal);
        }

        return CMYKA::of($colour);
    }

    /**
     * @see http://www.w3schools.com/colors/colors_names.asp
     */
    public static function literals(): Map
    {
        return self::$literals ?? self::$literals = Map::of('string', RGBA::class)
            ('aliceblue', RGBA::of('f0f8ff'))
            ('antiquewhite', RGBA::of('faebd7'))
            ('aqua', RGBA::of('0ff'))
            ('aquamarine', RGBA::of('7fffd4'))
            ('azure', RGBA::of('f0ffff'))
            ('beige', RGBA::of('f5f5dc'))
            ('bisque', RGBA::of('ffe4c4'))
            ('black', RGBA::of('000'))
            ('blanchedalmond', RGBA::of('ffebcd'))
            ('blue', RGBA::of('00f'))
            ('blueviolet', RGBA::of('8a2be2'))
            ('brown', RGBA::of('a52a2a'))
            ('burlywood', RGBA::of('deb887'))
            ('cadetblue', RGBA::of('5f9ea0'))
            ('chartreuse', RGBA::of('7fff00'))
            ('chocolate', RGBA::of('d2691e'))
            ('coral', RGBA::of('ff7f50'))
            ('cornflowerblue', RGBA::of('6495ed'))
            ('cornsilk', RGBA::of('fff8dc'))
            ('crimson', RGBA::of('dc143c'))
            ('cyan', RGBA::of('00ffff'))
            ('darkblue', RGBA::of('00008b'))
            ('darkcyan', RGBA::of('008b8b'))
            ('darkgoldenrod', RGBA::of('b8860b'))
            ('darkgray', RGBA::of('a9a9a9'))
            ('darkgrey', RGBA::of('a9a9a9'))
            ('darkgreen', RGBA::of('006400'))
            ('darkkhaki', RGBA::of('bdb76b'))
            ('darkmagenta', RGBA::of('8b008b'))
            ('darkolivegreen', RGBA::of('556b2f'))
            ('darkorange', RGBA::of('ff8c00'))
            ('darkorchid', RGBA::of('9932cc'))
            ('darkred', RGBA::of('8b0000'))
            ('darksalmon', RGBA::of('e9967a'))
            ('darkseagreen', RGBA::of('8fbc8f'))
            ('darkslateblue', RGBA::of('483d8b'))
            ('darkslategray', RGBA::of('2f4f4f'))
            ('darkslategrey', RGBA::of('2f4f4f'))
            ('darkturquoise', RGBA::of('00ced1'))
            ('darkviolet', RGBA::of('9400d3'))
            ('deeppink', RGBA::of('ff1493'))
            ('deepskyblue', RGBA::of('00bfff'))
            ('dimgray', RGBA::of('696969'))
            ('dimgrey', RGBA::of('696969'))
            ('dodgerblue', RGBA::of('1e90ff'))
            ('firebrick', RGBA::of('b22222'))
            ('floralwhite', RGBA::of('fffaf0'))
            ('forestgreen', RGBA::of('228b22'))
            ('fuchsia', RGBA::of('ff00ff'))
            ('gainsboro', RGBA::of('dcdcdc'))
            ('ghostwhite', RGBA::of('f8f8ff'))
            ('gold', RGBA::of('ffd700'))
            ('goldenrod', RGBA::of('daa520'))
            ('gray', RGBA::of('808080'))
            ('grey', RGBA::of('808080'))
            ('green', RGBA::of('008000'))
            ('greenyellow', RGBA::of('adff2f'))
            ('honeydew', RGBA::of('f0fff0'))
            ('hotpink', RGBA::of('ff69b4'))
            ('indianred', RGBA::of('cd5c5c'))
            ('indigo', RGBA::of('4b0082'))
            ('ivory', RGBA::of('fffff0'))
            ('khaki', RGBA::of('f0e68c'))
            ('lavender', RGBA::of('e6e6fa'))
            ('lavenderblush', RGBA::of('fff0f5'))
            ('lawngreen', RGBA::of('7cfc00'))
            ('lemonchiffon', RGBA::of('fffacd'))
            ('lightblue', RGBA::of('add8e6'))
            ('lightcoral', RGBA::of('f08080'))
            ('lightcyan', RGBA::of('e0ffff'))
            ('lightgoldenrodyellow', RGBA::of('fafad2'))
            ('lightgray', RGBA::of('d3d3d3'))
            ('lightgrey', RGBA::of('d3d3d3'))
            ('lightgreen', RGBA::of('90ee90'))
            ('lightpink', RGBA::of('ffb6c1'))
            ('lightsalmon', RGBA::of('ffa07a'))
            ('lightseagreen', RGBA::of('20b2aa'))
            ('lightskyblue', RGBA::of('87cefa'))
            ('lightslategray', RGBA::of('778899'))
            ('lightslategrey', RGBA::of('778899'))
            ('lightsteelblue', RGBA::of('b0c4de'))
            ('lightyellow', RGBA::of('ffffe0'))
            ('lime', RGBA::of('00ff00'))
            ('limegreen', RGBA::of('32cd32'))
            ('linen', RGBA::of('faf0e6'))
            ('magenta', RGBA::of('ff00ff'))
            ('maroon', RGBA::of('800000'))
            ('mediumaquamarine', RGBA::of('66cdaa'))
            ('mediumblue', RGBA::of('0000cd'))
            ('mediumorchid', RGBA::of('ba55d3'))
            ('mediumpurple', RGBA::of('9370db'))
            ('mediumseagreen', RGBA::of('3cb371'))
            ('mediumslateblue', RGBA::of('7b68ee'))
            ('mediumspringgreen', RGBA::of('00fa9a'))
            ('mediumturquoise', RGBA::of('48d1cc'))
            ('mediumvioletred', RGBA::of('c71585'))
            ('midnightblue', RGBA::of('191970'))
            ('mintcream', RGBA::of('f5fffa'))
            ('mistyrose', RGBA::of('ffe4e1'))
            ('moccasin', RGBA::of('ffe4b5'))
            ('navajowhite', RGBA::of('ffdead'))
            ('navy', RGBA::of('000080'))
            ('oldlace', RGBA::of('fdf5e6'))
            ('olive', RGBA::of('808000'))
            ('olivedrab', RGBA::of('6b8e23'))
            ('orange', RGBA::of('ffa500'))
            ('orangered', RGBA::of('ff4500'))
            ('orchid', RGBA::of('da70d6'))
            ('palegoldenrod', RGBA::of('eee8aa'))
            ('palegreen', RGBA::of('98fb98'))
            ('paleturquoise', RGBA::of('afeeee'))
            ('palevioletred', RGBA::of('db7093'))
            ('papayawhip', RGBA::of('ffefd5'))
            ('peachpuff', RGBA::of('ffdab9'))
            ('peru', RGBA::of('cd853f'))
            ('pink', RGBA::of('ffc0cb'))
            ('plum', RGBA::of('dda0dd'))
            ('powderblue', RGBA::of('b0e0e6'))
            ('purple', RGBA::of('800080'))
            ('rebeccapurple', RGBA::of('663399'))
            ('red', RGBA::of('ff0000'))
            ('rosybrown', RGBA::of('bc8f8f'))
            ('royalblue', RGBA::of('4169e1'))
            ('saddlebrown', RGBA::of('8b4513'))
            ('salmon', RGBA::of('fa8072'))
            ('sandybrown', RGBA::of('f4a460'))
            ('seagreen', RGBA::of('2e8b57'))
            ('seashell', RGBA::of('fff5ee'))
            ('sienna', RGBA::of('a0522d'))
            ('silver', RGBA::of('c0c0c0'))
            ('skyblue', RGBA::of('87ceeb'))
            ('slateblue', RGBA::of('6a5acd'))
            ('slategray', RGBA::of('708090'))
            ('slategrey', RGBA::of('708090'))
            ('snow', RGBA::of('fffafa'))
            ('springgreen', RGBA::of('00ff7f'))
            ('steelblue', RGBA::of('4682b4'))
            ('tan', RGBA::of('d2b48c'))
            ('teal', RGBA::of('008080'))
            ('thistle', RGBA::of('d8bfd8'))
            ('tomato', RGBA::of('ff6347'))
            ('turquoise', RGBA::of('40e0d0'))
            ('violet', RGBA::of('ee82ee'))
            ('wheat', RGBA::of('f5deb3'))
            ('white', RGBA::of('ffffff'))
            ('whitesmoke', RGBA::of('f5f5f5'))
            ('yellow', RGBA::of('ffff00'))
            ('yellowgreen', RGBA::of('9acd32'));
    }
}
