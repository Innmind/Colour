<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class RGBA
{
    private const HEXADECIMAL_PATTERN_WITH_ALPHA = '~^#?(?<red>[0-9a-fA-F]{1,2})(?<green>[0-9a-fA-F]{1,2})(?<blue>[0-9a-fA-F]{1,2})(?<alpha>[0-9a-fA-F]{1,2})$~';
    private const HEXADECIMAL_PATTERN_WITHOUT_ALPHA = '~^#?(?<red>[0-9a-fA-F]{1,2})(?<green>[0-9a-fA-F]{1,2})(?<blue>[0-9a-fA-F]{1,2})$~';
    private const RGB_FUNCTION_PATTERN = '~^rgb\((?<red>\d{1,3}), ?(?<green>\d{1,3}), ?(?<blue>\d{1,3})\)$~';
    private const PERCENTED_RGB_FUNCTION_PATTERN = '~^rgb\((?<red>\d{1,3})%, ?(?<green>\d{1,3})%, ?(?<blue>\d{1,3})%\)$~';
    private const RGBA_FUNCTION_PATTERN = '~^rgba\((?<red>\d{1,3}), ?(?<green>\d{1,3}), ?(?<blue>\d{1,3}), ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    private const PERCENTED_RGBA_FUNCTION_PATTERN = '~^rgba\((?<red>\d{1,3})%, ?(?<green>\d{1,3})%, ?(?<blue>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';

    private Red $red;
    private Blue $blue;
    private Green $green;
    private Alpha $alpha;
    private string $string;
    private ?HSLA $hsla = null;
    private ?CMYKA $cmyka = null;

    public function __construct(
        Red $red,
        Green $green,
        Blue $blue,
        Alpha $alpha = null
    ) {
        $this->red = $red;
        $this->blue = $blue;
        $this->green = $green;
        $this->alpha = $alpha ?? new Alpha(1);

        if ($this->alpha->atMaximum()) {
            $this->string = '#'.$this->toHexadecimal();
        } else {
            $this->string = \sprintf(
                'rgba(%s, %s, %s, %s)',
                $this->red->toInt(),
                $this->green->toInt(),
                $this->blue->toInt(),
                $this->alpha->toFloat(),
            );
        }
    }

    public static function of(string $colour): self
    {
        return self::maybe($colour)->match(
            static fn($self) => $self,
            static fn() => throw new DomainException($colour),
        );
    }

    /**
     * @return Maybe<self>
     */
    public static function maybe(string $colour): Maybe
    {
        $colour = Str::of($colour)->trim();

        return self::fromHexadecimal($colour)
            ->otherwise(static fn() => self::fromRGBFunction($colour))
            ->otherwise(static fn() => self::fromRGBAFunction($colour));
    }

    public function red(): Red
    {
        return $this->red;
    }

    public function blue(): Blue
    {
        return $this->blue;
    }

    public function green(): Green
    {
        return $this->green;
    }

    public function alpha(): Alpha
    {
        return $this->alpha;
    }

    public function addRed(Red $red): self
    {
        return new self(
            $this->red->add($red),
            $this->green,
            $this->blue,
            $this->alpha,
        );
    }

    public function subtractRed(Red $red): self
    {
        return new self(
            $this->red->subtract($red),
            $this->green,
            $this->blue,
            $this->alpha,
        );
    }

    public function addBlue(Blue $blue): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue->add($blue),
            $this->alpha,
        );
    }

    public function subtractBlue(Blue $blue): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue->subtract($blue),
            $this->alpha,
        );
    }

    public function addGreen(Green $green): self
    {
        return new self(
            $this->red,
            $this->green->add($green),
            $this->blue,
            $this->alpha,
        );
    }

    public function subtractGreen(Green $green): self
    {
        return new self(
            $this->red,
            $this->green->subtract($green),
            $this->blue,
            $this->alpha,
        );
    }

    public function addAlpha(Alpha $alpha): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue,
            $this->alpha->add($alpha),
        );
    }

    public function subtractAlpha(Alpha $alpha): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue,
            $this->alpha->subtract($alpha),
        );
    }

    public function equals(self $rgba): bool
    {
        return $this->red->equals($rgba->red()) &&
            $this->green->equals($rgba->green()) &&
            $this->blue->equals($rgba->blue()) &&
            $this->alpha->equals($rgba->alpha());
    }

    public function toHexadecimal(): string
    {
        $hex = $this->red->toString().$this->green->toString().$this->blue->toString();

        if (!$this->alpha->atMaximum()) {
            $hex .= $this->alpha()->toHexadecimal();
        }

        return $hex;
    }

    public function toHSLA(): HSLA
    {
        if ($this->hsla instanceof HSLA) {
            return $this->hsla;
        }

        $red = $this->red->toInt() / 255;
        $green = $this->green->toInt() / 255;
        $blue = $this->blue->toInt() / 255;

        $max = \max($red, $green, $blue);
        $min = \min($red, $green, $blue);
        $lightness = ($max + $min) / 2;

        if ($max === $min) {
            return $this->hsla = new HSLA(
                new Hue(0),
                new Saturation(0),
                new Lightness((int) \round($lightness * 100)),
                $this->alpha,
            );
        }

        $delta = $max - $min;
        $saturation = $lightness > 0.5 ? $delta / (2 - $max - $min) : $delta / ($max + $min);
        $hue = 0;

        switch ($max) {
            case $red:
                $hue = (($green - $blue) / $delta) + ($green < $blue ? 6 : 0);
                break;
            case $green:
                $hue = (($blue - $red) / $delta) + 2;
                break;
            case $blue:
                $hue = (($red - $green) / $delta) + 4;
                break;
        }

        $hue *= 60;

        return $this->hsla = new HSLA(
            new Hue((int) \round($hue)),
            new Saturation((int) \round($saturation * 100)),
            new Lightness((int) \round($lightness * 100)),
            $this->alpha,
        );
    }

    public function toCMYKA(): CMYKA
    {
        if ($this->cmyka instanceof CMYKA) {
            return $this->cmyka;
        }

        $red = $this->red->toInt() / 255;
        $green = $this->green->toInt() / 255;
        $blue = $this->blue->toInt() / 255;

        if (
            $this->red->atMinimum() &&
            $this->green->atMinimum() &&
            $this->blue->atMinimum()
        ) {
            return $this->cmyka = new CMYKA(
                new Cyan(0),
                new Magenta(0),
                new Yellow(0),
                new Black(100),
                $this->alpha,
            );
        }

        $black = \min(1 - $red, 1 - $green, 1 - $blue);
        $cyan = (1 - $red - $black) / (1 - $black);
        $magenta = (1 - $green - $black) / (1 - $black);
        $yellow = (1 - $blue - $black) / (1 - $black);

        return $this->cmyka = new CMYKA(
            new Cyan((int) \round($cyan * 100)),
            new Magenta((int) \round($magenta * 100)),
            new Yellow((int) \round($yellow * 100)),
            new Black((int) \round($black * 100)),
            $this->alpha,
        );
    }

    public function toRGBA(): self
    {
        return $this;
    }

    public function toString(): string
    {
        return $this->string;
    }

    /**
     * @return Maybe<self>
     */
    private static function fromHexadecimal(Str $colour): Maybe
    {
        return self::fromHexadecimalWithAlpha($colour)->otherwise(
            static fn() => self::fromHexadecimalWithoutAlpha($colour),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromHexadecimalWithAlpha(Str $colour): Maybe
    {
        if (!$colour->matches(self::HEXADECIMAL_PATTERN_WITH_ALPHA)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        if ($colour->matches('/^#/')) {
            $colour = $colour->substring(1);
        }

        if (
            $colour->length() !== 4 &&
            $colour->length() !== 8
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::HEXADECIMAL_PATTERN_WITH_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->flatMap(static fn($red) => Red::fromHexadecimal($red));
        $green = $matches
            ->get('green')
            ->flatMap(static fn($green) => Green::fromHexadecimal($green));
        $blue = $matches
            ->get('blue')
            ->flatMap(static fn($blue) => Blue::fromHexadecimal($blue));
        $alpha = $matches
            ->get('alpha')
            ->flatMap(static fn($alpha) => Alpha::fromHexadecimal($alpha));

        return Maybe::all($red, $green, $blue, $alpha)->map(
            static fn(Red $red, Green $green, Blue $blue, Alpha $alpha) => new self(
                $red,
                $green,
                $blue,
                $alpha,
            ),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromHexadecimalWithoutAlpha(Str $colour): Maybe
    {
        if (!$colour->matches(self::HEXADECIMAL_PATTERN_WITHOUT_ALPHA)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        if ($colour->matches('/^#/')) {
            $colour = $colour->substring(1);
        }

        if (
            $colour->length() !== 3 &&
            $colour->length() !== 6
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::HEXADECIMAL_PATTERN_WITHOUT_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->flatMap(static fn($red) => Red::fromHexadecimal($red));
        $green = $matches
            ->get('green')
            ->flatMap(static fn($green) => Green::fromHexadecimal($green));
        $blue = $matches
            ->get('blue')
            ->flatMap(static fn($blue) => Blue::fromHexadecimal($blue));

        return Maybe::all($red, $green, $blue)->map(
            static fn(Red $red, Green $green, Blue $blue) => new self(
                $red,
                $green,
                $blue,
            ),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromRGBFunction(Str $colour): Maybe
    {
        return self::fromRGBFunctionWithPoints($colour)->otherwise(
            static fn() => self::fromRGBFunctionWithPercents($colour),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromRGBFunctionWithPoints(Str $colour): Maybe
    {
        if (!$colour->matches(self::RGB_FUNCTION_PATTERN)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::RGB_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->flatMap(static fn($red) => Red::of($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->flatMap(static fn($green) => Green::of($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->flatMap(static fn($blue) => Blue::of($blue));

        return Maybe::all($red, $green, $blue)->map(
            static fn(Red $red, Green $green, Blue $blue) => new self(
                $red,
                $green,
                $blue,
            ),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromRGBFunctionWithPercents(Str $colour): Maybe
    {
        if (!$colour->matches(self::PERCENTED_RGB_FUNCTION_PATTERN)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::PERCENTED_RGB_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->flatMap(static fn($red) => Intensity::of($red))
            ->flatMap(static fn($red) => Red::fromIntensity($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->flatMap(static fn($green) => Intensity::of($green))
            ->flatMap(static fn($green) => Green::fromIntensity($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->flatMap(static fn($blue) => Intensity::of($blue))
            ->flatMap(static fn($blue) => Blue::fromIntensity($blue));

        return Maybe::all($red, $green, $blue)->map(
            static fn(Red $red, Green $green, Blue $blue) => new self(
                $red,
                $green,
                $blue,
            ),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromRGBAFunction(Str $colour): Maybe
    {
        return self::fromRGBAFunctionWithPoints($colour)->otherwise(
            static fn() => self::fromRGBAFunctionWithPercents($colour),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromRGBAFunctionWithPoints(Str $colour): Maybe
    {
        if (!$colour->matches(self::RGBA_FUNCTION_PATTERN)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::RGBA_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->flatMap(static fn($red) => Red::of($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->flatMap(static fn($green) => Green::of($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->flatMap(static fn($blue) => Blue::of($blue));
        $alpha = $matches
            ->get('alpha')
            ->filter(static fn($alpha) => \is_numeric($alpha))
            ->map(static fn($alpha) => (float) $alpha)
            ->flatMap(static fn($alpha) => Alpha::of($alpha));

        return Maybe::all($red, $green, $blue, $alpha)->map(
            static fn(Red $red, Green $green, Blue $blue, Alpha $alpha) => new self(
                $red,
                $green,
                $blue,
                $alpha,
            ),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function fromRGBAFunctionWithPercents(Str $colour): Maybe
    {
        if (!$colour->matches(self::PERCENTED_RGBA_FUNCTION_PATTERN)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::PERCENTED_RGBA_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->flatMap(static fn($red) => Intensity::of($red))
            ->flatMap(static fn($red) => Red::fromIntensity($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->flatMap(static fn($green) => Intensity::of($green))
            ->flatMap(static fn($green) => Green::fromIntensity($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->flatMap(static fn($blue) => Intensity::of($blue))
            ->flatMap(static fn($blue) => Blue::fromIntensity($blue));
        $alpha = $matches
            ->get('alpha')
            ->filter(static fn($alpha) => \is_numeric($alpha))
            ->map(static fn($alpha) => (float) $alpha)
            ->flatMap(static fn($alpha) => Alpha::of($alpha));

        return Maybe::all($red, $green, $blue, $alpha)->map(
            static fn(Red $red, Green $green, Blue $blue, Alpha $alpha) => new self(
                $red,
                $green,
                $blue,
                $alpha,
            ),
        );
    }
}
