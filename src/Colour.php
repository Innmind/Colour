<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\DomainException;
use Innmind\Immutable\{
    Maybe,
};

/**
 * @psalm-immutable
 */
enum Colour
{
    // variants are accessible via methods to avoid having too many cases on the
    // enum, because Psalm can't handle more than 101 cases
    case aliceblue;
    case antiquewhite;
    case aqua;
    case aquamarine;
    case azure;
    case beige;
    case bisque;
    case black;
    case blanchedalmond;
    case blue;
    case blueviolet;
    case brown;
    case burlywood;
    case cadetblue;
    case chartreuse;
    case chocolate;
    case coral;
    case cornflowerblue;
    case cornsilk;
    case crimson;
    case cyan;
    case deeppink;
    case deepskyblue;
    case dimgrey;
    case dodgerblue;
    case firebrick;
    case floralwhite;
    case forestgreen;
    case fuchsia;
    case gainsboro;
    case ghostwhite;
    case gold;
    case goldenrod;
    case grey;
    case green;
    case greenyellow;
    case honeydew;
    case hotpink;
    case indianred;
    case indigo;
    case ivory;
    case khaki;
    case lavender;
    case lavenderblush;
    case lawngreen;
    case lemonchiffon;
    case lime;
    case limegreen;
    case linen;
    case magenta;
    case maroon;
    case midnightblue;
    case mintcream;
    case mistyrose;
    case moccasin;
    case navajowhite;
    case navy;
    case oldlace;
    case olive;
    case olivedrab;
    case orange;
    case orangered;
    case orchid;
    case papayawhip;
    case peachpuff;
    case peru;
    case pink;
    case plum;
    case powderblue;
    case purple;
    case rebeccapurple;
    case red;
    case rosybrown;
    case royalblue;
    case saddlebrown;
    case salmon;
    case sandybrown;
    case seagreen;
    case seashell;
    case sienna;
    case silver;
    case skyblue;
    case slateblue;
    case slategrey;
    case snow;
    case springgreen;
    case steelblue;
    case tan;
    case teal;
    case thistle;
    case tomato;
    case turquoise;
    case violet;
    case wheat;
    case white;
    case whitesmoke;
    case yellow;
    case yellowgreen;

    /**
     * @psalm-pure
     *
     * @throws DomainException
     */
    public static function of(string $colour): RGBA|HSLA|CMYKA
    {
        return self::maybe($colour)->match(
            static fn($colour) => $colour,
            static fn() => throw new DomainException($colour),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<RGBA|HSLA|CMYKA>
     */
    public static function maybe(string $colour): Maybe
    {
        return RGBA::maybe($colour)
            ->otherwise(static fn() => HSLA::maybe($colour))
            ->otherwise(static fn() => CMYKA::maybe($colour));
    }

    /**
     * @see http://www.w3schools.com/colors/colors_names.asp
     */
    public function toRGBA(): RGBA
    {
        return match ($this) {
            self::aliceblue => RGBA::of('f0f8ff'),
            self::antiquewhite => RGBA::of('faebd7'),
            self::aqua => RGBA::of('0ff'),
            self::aquamarine => RGBA::of('7fffd4'),
            self::azure => RGBA::of('f0ffff'),
            self::beige => RGBA::of('f5f5dc'),
            self::bisque => RGBA::of('ffe4c4'),
            self::black => RGBA::of('000'),
            self::blanchedalmond => RGBA::of('ffebcd'),
            self::blue => RGBA::of('00f'),
            self::blueviolet => RGBA::of('8a2be2'),
            self::brown => RGBA::of('a52a2a'),
            self::burlywood => RGBA::of('deb887'),
            self::cadetblue => RGBA::of('5f9ea0'),
            self::chartreuse => RGBA::of('7fff00'),
            self::chocolate => RGBA::of('d2691e'),
            self::coral => RGBA::of('ff7f50'),
            self::cornflowerblue => RGBA::of('6495ed'),
            self::cornsilk => RGBA::of('fff8dc'),
            self::crimson => RGBA::of('dc143c'),
            self::cyan => RGBA::of('00ffff'),
            self::deeppink => RGBA::of('ff1493'),
            self::deepskyblue => RGBA::of('00bfff'),
            self::dimgrey => RGBA::of('696969'),
            self::dodgerblue => RGBA::of('1e90ff'),
            self::firebrick => RGBA::of('b22222'),
            self::floralwhite => RGBA::of('fffaf0'),
            self::forestgreen => RGBA::of('228b22'),
            self::fuchsia => RGBA::of('ff00ff'),
            self::gainsboro => RGBA::of('dcdcdc'),
            self::ghostwhite => RGBA::of('f8f8ff'),
            self::gold => RGBA::of('ffd700'),
            self::goldenrod => RGBA::of('daa520'),
            self::grey => RGBA::of('808080'),
            self::green => RGBA::of('008000'),
            self::greenyellow => RGBA::of('adff2f'),
            self::honeydew => RGBA::of('f0fff0'),
            self::hotpink => RGBA::of('ff69b4'),
            self::indianred => RGBA::of('cd5c5c'),
            self::indigo => RGBA::of('4b0082'),
            self::ivory => RGBA::of('fffff0'),
            self::khaki => RGBA::of('f0e68c'),
            self::lavender => RGBA::of('e6e6fa'),
            self::lavenderblush => RGBA::of('fff0f5'),
            self::lawngreen => RGBA::of('7cfc00'),
            self::lemonchiffon => RGBA::of('fffacd'),
            self::lime => RGBA::of('00ff00'),
            self::limegreen => RGBA::of('32cd32'),
            self::linen => RGBA::of('faf0e6'),
            self::magenta => RGBA::of('ff00ff'),
            self::maroon => RGBA::of('800000'),
            self::midnightblue => RGBA::of('191970'),
            self::mintcream => RGBA::of('f5fffa'),
            self::mistyrose => RGBA::of('ffe4e1'),
            self::moccasin => RGBA::of('ffe4b5'),
            self::navajowhite => RGBA::of('ffdead'),
            self::navy => RGBA::of('000080'),
            self::oldlace => RGBA::of('fdf5e6'),
            self::olive => RGBA::of('808000'),
            self::olivedrab => RGBA::of('6b8e23'),
            self::orange => RGBA::of('ffa500'),
            self::orangered => RGBA::of('ff4500'),
            self::orchid => RGBA::of('da70d6'),
            self::papayawhip => RGBA::of('ffefd5'),
            self::peachpuff => RGBA::of('ffdab9'),
            self::peru => RGBA::of('cd853f'),
            self::pink => RGBA::of('ffc0cb'),
            self::plum => RGBA::of('dda0dd'),
            self::powderblue => RGBA::of('b0e0e6'),
            self::purple => RGBA::of('800080'),
            self::rebeccapurple => RGBA::of('663399'),
            self::red => RGBA::of('ff0000'),
            self::rosybrown => RGBA::of('bc8f8f'),
            self::royalblue => RGBA::of('4169e1'),
            self::saddlebrown => RGBA::of('8b4513'),
            self::salmon => RGBA::of('fa8072'),
            self::sandybrown => RGBA::of('f4a460'),
            self::seagreen => RGBA::of('2e8b57'),
            self::seashell => RGBA::of('fff5ee'),
            self::sienna => RGBA::of('a0522d'),
            self::silver => RGBA::of('c0c0c0'),
            self::skyblue => RGBA::of('87ceeb'),
            self::slateblue => RGBA::of('6a5acd'),
            self::slategrey => RGBA::of('708090'),
            self::snow => RGBA::of('fffafa'),
            self::springgreen => RGBA::of('00ff7f'),
            self::steelblue => RGBA::of('4682b4'),
            self::tan => RGBA::of('d2b48c'),
            self::teal => RGBA::of('008080'),
            self::thistle => RGBA::of('d8bfd8'),
            self::tomato => RGBA::of('ff6347'),
            self::turquoise => RGBA::of('40e0d0'),
            self::violet => RGBA::of('ee82ee'),
            self::wheat => RGBA::of('f5deb3'),
            self::white => RGBA::of('ffffff'),
            self::whitesmoke => RGBA::of('f5f5f5'),
            self::yellow => RGBA::of('ffff00'),
            self::yellowgreen => RGBA::of('9acd32'),
        };
    }

    public function light(): RGBA
    {
        /** @psalm-suppress UnhandledMatchCondition */
        return match ($this) {
            self::blue => RGBA::of('add8e6'),
            self::coral => RGBA::of('f08080'),
            self::cyan => RGBA::of('e0ffff'),
            self::grey => RGBA::of('d3d3d3'),
            self::green => RGBA::of('90ee90'),
            self::pink => RGBA::of('ffb6c1'),
            self::salmon => RGBA::of('ffa07a'),
            self::seagreen => RGBA::of('20b2aa'),
            self::skyblue => RGBA::of('87cefa'),
            self::slategrey => RGBA::of('778899'),
            self::steelblue => RGBA::of('b0c4de'),
            self::yellow => RGBA::of('ffffe0'),
        };
    }

    public function dark(): RGBA
    {
        /** @psalm-suppress UnhandledMatchCondition */
        return match ($this) {
            self::blue => RGBA::of('00008b'),
            self::cyan => RGBA::of('008b8b'),
            self::goldenrod => RGBA::of('b8860b'),
            self::grey => RGBA::of('a9a9a9'),
            self::green => RGBA::of('006400'),
            self::khaki => RGBA::of('bdb76b'),
            self::magenta => RGBA::of('8b008b'),
            self::orange => RGBA::of('ff8c00'),
            self::orchid => RGBA::of('9932cc'),
            self::red => RGBA::of('8b0000'),
            self::salmon => RGBA::of('e9967a'),
            self::seagreen => RGBA::of('8fbc8f'),
            self::slateblue => RGBA::of('483d8b'),
            self::slategrey => RGBA::of('2f4f4f'),
            self::turquoise => RGBA::of('00ced1'),
            self::violet => RGBA::of('9400d3'),
        };
    }

    public function medium(): RGBA
    {
        /** @psalm-suppress UnhandledMatchCondition */
        return match ($this) {
            self::aquamarine => RGBA::of('66cdaa'),
            self::blue => RGBA::of('0000cd'),
            self::orchid => RGBA::of('ba55d3'),
            self::purple => RGBA::of('9370db'),
            self::seagreen => RGBA::of('3cb371'),
            self::slateblue => RGBA::of('7b68ee'),
            self::springgreen => RGBA::of('00fa9a'),
            self::turquoise => RGBA::of('48d1cc'),
        };
    }

    public function pale(): RGBA
    {
        /** @psalm-suppress UnhandledMatchCondition */
        return match ($this) {
            self::goldenrod => RGBA::of('eee8aa'),
            self::green => RGBA::of('98fb98'),
            self::turquoise => RGBA::of('afeeee'),
        };
    }
}
