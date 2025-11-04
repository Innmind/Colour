<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\{
    Str,
    Maybe,
    Attempt,
};

/**
 * @psalm-immutable
 */
final class RGBA
{
    private const HEXADECIMAL_PATTERN_WITH_ALPHA = '~^#?(?<red>[0-9a-fA-F]{1,2})(?<green>[0-9a-fA-F]{1,2})(?<blue>[0-9a-fA-F]{1,2})(?<alpha>[0-9a-fA-F]{1,2})$~';
    private const HEXADECIMAL_PATTERN_WITHOUT_ALPHA = '~^#?(?<red>[0-9a-fA-F]{1,2})(?<green>[0-9a-fA-F]{1,2})(?<blue>[0-9a-fA-F]{1,2})$~';
    private const RGB_FUNCTION_PATTERN = '~^rgb\((?<red>\d{1,3}), ?(?<green>\d{1,3}), ?(?<blue>\d{1,3})\)$~';
    private const PERCENTED_RGB_FUNCTION_PATTERN = '~^rgb\((?<red>\d{1,3})%, ?(?<green>\d{1,3})%, ?(?<blue>\d{1,3})%\)$~';
    private const RGBA_FUNCTION_PATTERN = '~^rgba\((?<red>\d{1,3}), ?(?<green>\d{1,3}), ?(?<blue>\d{1,3}), ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    private const PERCENTED_RGBA_FUNCTION_PATTERN = '~^rgba\((?<red>\d{1,3})%, ?(?<green>\d{1,3})%, ?(?<blue>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';

    private function __construct(
        private Red $red,
        private Green $green,
        private Blue $blue,
        private Alpha $alpha,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function from(
        Red $red,
        Green $green,
        Blue $blue,
        ?Alpha $alpha = null,
    ): self {
        return new self($red, $green, $blue, $alpha ?? Alpha::max());
    }

    /**
     * @psalm-pure
     *
     * @throws \Exception
     */
    public static function of(string $colour): self
    {
        return self::attempt($colour)->unwrap();
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $colour): Maybe
    {
        return self::attempt($colour)->maybe();
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    public static function attempt(string $colour): Attempt
    {
        $colour = Str::of($colour)->trim();

        return self::fromHexadecimal($colour)
            ->recover(static fn() => self::fromRGBFunction($colour))
            ->recover(static fn() => self::fromRGBAFunction($colour));
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
        $red = $this->red->toInt() / 255;
        $green = $this->green->toInt() / 255;
        $blue = $this->blue->toInt() / 255;

        $max = \max($red, $green, $blue);
        $min = \min($red, $green, $blue);
        $lightness = ($max + $min) / 2;

        if ($max === $min) {
            return HSLA::from(
                Hue::at(0),
                Saturation::at(0),
                Lightness::of((int) \round($lightness * 100))->unwrap(),
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

        return HSLA::from(
            Hue::of((int) \round($hue))->unwrap(),
            Saturation::of((int) \round($saturation * 100))->unwrap(),
            Lightness::of((int) \round($lightness * 100))->unwrap(),
            $this->alpha,
        );
    }

    public function toCMYKA(): CMYKA
    {
        $red = $this->red->toInt() / 255;
        $green = $this->green->toInt() / 255;
        $blue = $this->blue->toInt() / 255;

        if (
            $this->red->atMinimum() &&
            $this->green->atMinimum() &&
            $this->blue->atMinimum()
        ) {
            return CMYKA::from(
                Cyan::at(0),
                Magenta::at(0),
                Yellow::at(0),
                Black::at(100),
                $this->alpha,
            );
        }

        $black = \min(1 - $red, 1 - $green, 1 - $blue);
        $cyan = (1 - $red - $black) / (1 - $black);
        $magenta = (1 - $green - $black) / (1 - $black);
        $yellow = (1 - $blue - $black) / (1 - $black);

        return CMYKA::from(
            Cyan::of((int) \round($cyan * 100))->unwrap(),
            Magenta::of((int) \round($magenta * 100))->unwrap(),
            Yellow::of((int) \round($yellow * 100))->unwrap(),
            Black::of((int) \round($black * 100))->unwrap(),
            $this->alpha,
        );
    }

    public function toRGBA(): self
    {
        return $this;
    }

    public function toString(): string
    {
        if ($this->alpha->atMaximum()) {
            return '#'.$this->toHexadecimal();
        }

        return \sprintf(
            'rgba(%s, %s, %s, %s)',
            $this->red->toInt(),
            $this->green->toInt(),
            $this->blue->toInt(),
            $this->alpha->toFloat(),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromHexadecimal(Str $colour): Attempt
    {
        return self::fromHexadecimalWithAlpha($colour)->recover(
            static fn() => self::fromHexadecimalWithoutAlpha($colour),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromHexadecimalWithAlpha(Str $colour): Attempt
    {
        if ($colour->startsWith('#')) {
            $colour = $colour->drop(1);
        }

        if (
            $colour->length() !== 4 &&
            $colour->length() !== 8
        ) {
            /** @var Attempt<self> */
            return Attempt::error(new \DomainException('Invalid length'));
        }

        $matches = $colour
            ->capture(self::HEXADECIMAL_PATTERN_WITH_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->attempt(static fn() => new \DomainException("Red not found in '{$colour->toString()}'"))
            ->flatMap(static fn($red) => Red::fromHexadecimal($red));
        $green = $matches
            ->get('green')
            ->attempt(static fn() => new \DomainException("Green not found in '{$colour->toString()}'"))
            ->flatMap(static fn($green) => Green::fromHexadecimal($green));
        $blue = $matches
            ->get('blue')
            ->attempt(static fn() => new \DomainException("Blue not found in '{$colour->toString()}'"))
            ->flatMap(static fn($blue) => Blue::fromHexadecimal($blue));
        $alpha = $matches
            ->get('alpha')
            ->attempt(static fn() => new \DomainException("Alpha not found in '{$colour->toString()}'"))
            ->flatMap(static fn($alpha) => Alpha::fromHexadecimal($alpha));

        return $red->flatMap(
            static fn($red) => $green->flatMap(
                static fn($green) => $blue->flatMap(
                    static fn($blue) => $alpha->map(
                        static fn($alpha) => self::from(
                            $red,
                            $green,
                            $blue,
                            $alpha,
                        ),
                    ),
                ),
            ),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromHexadecimalWithoutAlpha(Str $colour): Attempt
    {
        if ($colour->startsWith('#')) {
            $colour = $colour->drop(1);
        }

        if (
            $colour->length() !== 3 &&
            $colour->length() !== 6
        ) {
            /** @var Attempt<self> */
            return Attempt::error(new \DomainException('Invalid length'));
        }

        $matches = $colour
            ->capture(self::HEXADECIMAL_PATTERN_WITHOUT_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->attempt(static fn() => new \DomainException("Red not found in '{$colour->toString()}'"))
            ->flatMap(static fn($red) => Red::fromHexadecimal($red));
        $green = $matches
            ->get('green')
            ->attempt(static fn() => new \DomainException("Green not found in '{$colour->toString()}'"))
            ->flatMap(static fn($green) => Green::fromHexadecimal($green));
        $blue = $matches
            ->get('blue')
            ->attempt(static fn() => new \DomainException("Blue not found in '{$colour->toString()}'"))
            ->flatMap(static fn($blue) => Blue::fromHexadecimal($blue));

        return $red->flatMap(
            static fn($red) => $green->flatMap(
                static fn($green) => $blue->map(
                    static fn($blue) => self::from(
                        $red,
                        $green,
                        $blue,
                    ),
                ),
            ),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromRGBFunction(Str $colour): Attempt
    {
        return self::fromRGBFunctionWithPoints($colour)->recover(
            static fn() => self::fromRGBFunctionWithPercents($colour),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromRGBFunctionWithPoints(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::RGB_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->attempt(static fn() => new \DomainException("Red not found in '{$colour->toString()}'"))
            ->flatMap(static fn($red) => Red::of($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->attempt(static fn() => new \DomainException("Grren not found in '{$colour->toString()}'"))
            ->flatMap(static fn($green) => Green::of($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->attempt(static fn() => new \DomainException("Blue not found in '{$colour->toString()}'"))
            ->flatMap(static fn($blue) => Blue::of($blue));

        return $red->flatMap(
            static fn($red) => $green->flatMap(
                static fn($green) => $blue->map(
                    static fn($blue) => self::from(
                        $red,
                        $green,
                        $blue,
                    ),
                ),
            ),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromRGBFunctionWithPercents(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::PERCENTED_RGB_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->attempt(static fn() => new \DomainException("Red not found in '{$colour->toString()}'"))
            ->flatMap(static fn($red) => Intensity::of($red))
            ->flatMap(static fn($red) => Red::fromIntensity($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->attempt(static fn() => new \DomainException("Green not found in '{$colour->toString()}'"))
            ->flatMap(static fn($green) => Intensity::of($green))
            ->flatMap(static fn($green) => Green::fromIntensity($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->attempt(static fn() => new \DomainException("Blue not found in '{$colour->toString()}'"))
            ->flatMap(static fn($blue) => Intensity::of($blue))
            ->flatMap(static fn($blue) => Blue::fromIntensity($blue));

        return $red->flatMap(
            static fn($red) => $green->flatMap(
                static fn($green) => $blue->map(
                    static fn($blue) => self::from(
                        $red,
                        $green,
                        $blue,
                    ),
                ),
            ),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromRGBAFunction(Str $colour): Attempt
    {
        return self::fromRGBAFunctionWithPoints($colour)->recover(
            static fn() => self::fromRGBAFunctionWithPercents($colour),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromRGBAFunctionWithPoints(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::RGBA_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->attempt(static fn() => new \DomainException("Red not found in '{$colour->toString()}'"))
            ->flatMap(static fn($red) => Red::of($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->attempt(static fn() => new \DomainException("Green not found in '{$colour->toString()}'"))
            ->flatMap(static fn($green) => Green::of($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->attempt(static fn() => new \DomainException("Blue not found in '{$colour->toString()}'"))
            ->flatMap(static fn($blue) => Blue::of($blue));
        $alpha = $matches
            ->get('alpha')
            ->filter(static fn($alpha) => \is_numeric($alpha))
            ->map(static fn($alpha) => (float) $alpha)
            ->attempt(static fn() => new \DomainException("Alpha not found in '{$colour->toString()}'"))
            ->flatMap(static fn($alpha) => Alpha::of($alpha));

        return $red->flatMap(
            static fn($red) => $green->flatMap(
                static fn($green) => $blue->flatMap(
                    static fn($blue) => $alpha->map(
                        static fn($alpha) => self::from(
                            $red,
                            $green,
                            $blue,
                            $alpha,
                        ),
                    ),
                ),
            ),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function fromRGBAFunctionWithPercents(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::PERCENTED_RGBA_FUNCTION_PATTERN)
            ->map(static fn($_, $match) => $match->toString());
        $red = $matches
            ->get('red')
            ->filter(static fn($red) => \is_numeric($red))
            ->map(static fn($red) => (int) $red)
            ->attempt(static fn() => new \DomainException("Red not found in '{$colour->toString()}'"))
            ->flatMap(static fn($red) => Intensity::of($red))
            ->flatMap(static fn($red) => Red::fromIntensity($red));
        $green = $matches
            ->get('green')
            ->filter(static fn($green) => \is_numeric($green))
            ->map(static fn($green) => (int) $green)
            ->attempt(static fn() => new \DomainException("Green not found in '{$colour->toString()}'"))
            ->flatMap(static fn($green) => Intensity::of($green))
            ->flatMap(static fn($green) => Green::fromIntensity($green));
        $blue = $matches
            ->get('blue')
            ->filter(static fn($blue) => \is_numeric($blue))
            ->map(static fn($blue) => (int) $blue)
            ->attempt(static fn() => new \DomainException("Blue not found in '{$colour->toString()}'"))
            ->flatMap(static fn($blue) => Intensity::of($blue))
            ->flatMap(static fn($blue) => Blue::fromIntensity($blue));
        $alpha = $matches
            ->get('alpha')
            ->filter(static fn($alpha) => \is_numeric($alpha))
            ->map(static fn($alpha) => (float) $alpha)
            ->attempt(static fn() => new \DomainException("Alpha not found in '{$colour->toString()}'"))
            ->flatMap(static fn($alpha) => Alpha::of($alpha));

        return $red->flatMap(
            static fn($red) => $green->flatMap(
                static fn($green) => $blue->flatMap(
                    static fn($blue) => $alpha->map(
                        static fn($alpha) => self::from(
                            $red,
                            $green,
                            $blue,
                            $alpha,
                        ),
                    ),
                ),
            ),
        );
    }
}
