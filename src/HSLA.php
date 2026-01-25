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
final class HSLA
{
    private const PATTERN_WITH_ALPHA = '~^hsla\((?<hue>\d{1,3}), ?(?<saturation>\d{1,3})%, ?(?<lightness>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    private const PATTERN_WITHOUT_ALPHA = '~^hsl\((?<hue>\d{1,3}), ?(?<saturation>\d{1,3})%, ?(?<lightness>\d{1,3})%\)$~';

    private function __construct(
        private Hue $hue,
        private Saturation $saturation,
        private Lightness $lightness,
        private Alpha $alpha,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function from(
        Hue $hue,
        Saturation $saturation,
        Lightness $lightness,
        ?Alpha $alpha = null,
    ): self {
        return new self($hue, $saturation, $lightness, $alpha ?? Alpha::max());
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

        return self::withAlpha($colour)->recover(
            static fn() => self::withoutAlpha($colour),
        );
    }

    public function hue(): Hue
    {
        return $this->hue;
    }

    public function saturation(): Saturation
    {
        return $this->saturation;
    }

    public function lightness(): Lightness
    {
        return $this->lightness;
    }

    public function alpha(): Alpha
    {
        return $this->alpha;
    }

    public function rotateBy(int $degress): self
    {
        return new self(
            $this->hue->rotateBy($degress),
            $this->saturation,
            $this->lightness,
            $this->alpha,
        );
    }

    public function addSaturation(Saturation $saturation): self
    {
        return new self(
            $this->hue,
            $this->saturation->add($saturation),
            $this->lightness,
            $this->alpha,
        );
    }

    public function subtractSaturation(Saturation $saturation): self
    {
        return new self(
            $this->hue,
            $this->saturation->subtract($saturation),
            $this->lightness,
            $this->alpha,
        );
    }

    public function addLightness(Lightness $lightness): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness->add($lightness),
            $this->alpha,
        );
    }

    public function subtractLightness(Lightness $lightness): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness->subtract($lightness),
            $this->alpha,
        );
    }

    public function addAlpha(Alpha $alpha): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness,
            $this->alpha->add($alpha),
        );
    }

    public function subtractAlpha(Alpha $alpha): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness,
            $this->alpha->subtract($alpha),
        );
    }

    public function equals(self $hsla): bool
    {
        return $this->hue->equals($hsla->hue()) &&
            $this->saturation->equals($hsla->saturation()) &&
            $this->lightness->equals($hsla->lightness()) &&
            $this->alpha->equals($hsla->alpha());
    }

    public function toRGBA(): RGBA
    {
        $lightness = $this->lightness->toInt() / 100;

        if ($this->saturation->atMinimum()) {
            return RGBA::from(
                Red::of((int) \round($lightness * 255))->unwrap(),
                Green::of((int) \round($lightness * 255))->unwrap(),
                Blue::of((int) \round($lightness * 255))->unwrap(),
                $this->alpha,
            );
        }

        $hue = $this->hue->toInt() / 360;
        $saturation = $this->saturation->toInt() / 100;

        //can't find a formula on internet where $q and $p are explained
        $q = $lightness < 0.5 ? $lightness * (1 + $saturation) : $lightness + $saturation - $lightness * $saturation;
        $p = 2 * $lightness - $q;

        return RGBA::from(
            Red::of((int) \round($this->hueToPoint($p, $q, $hue + 1 / 3) * 255))->unwrap(),
            Green::of((int) \round($this->hueToPoint($p, $q, $hue) * 255))->unwrap(),
            Blue::of((int) \round($this->hueToPoint($p, $q, $hue - 1 / 3) * 255))->unwrap(),
            $this->alpha,
        );
    }

    public function toCMYKA(): CMYKA
    {
        return $this->toRGBA()->toCMYKA();
    }

    public function toHSLA(): self
    {
        return $this;
    }

    public function toString(): string
    {
        if ($this->alpha->atMaximum()) {
            return \sprintf(
                'hsl(%s, %s%%, %s%%)',
                $this->hue->toString(),
                $this->saturation->toString(),
                $this->lightness->toString(),
            );
        }

        return \sprintf(
            'hsla(%s, %s%%, %s%%, %s)',
            $this->hue->toString(),
            $this->saturation->toString(),
            $this->lightness->toString(),
            $this->alpha->toFloat(),
        );
    }

    /**
     * Formula taken from the internet, don't know what it means
     *
     * @param float $p Don't know what it represents
     * @param float $q Don't know what it represents
     * @param float $t Don't know what it represents
     */
    private function hueToPoint(float $p, float $q, float $t): float
    {
        if ($t < 0) {
            $t += 1;
        }

        if ($t > 1) {
            $t -= 1;
        }

        switch (true) {
            case $t < 1 / 6:
                return $p + ($q - $p) * 6 * $t;

            case $t < 1 / 2:
                return $q;

            case $t < 2 / 3:
                return $p + ($q - $p) * (2 / 3 - $t) * 6;
        }

        return $p;
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function withAlpha(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::PATTERN_WITH_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $hue = $matches
            ->get('hue')
            ->filter(\is_numeric(...))
            ->map(static fn($hue) => (int) $hue)
            ->attempt(static fn() => new \DomainException("Hue not found in '{$colour->toString()}'"))
            ->flatMap(Hue::of(...));
        $saturation = $matches
            ->get('saturation')
            ->filter(\is_numeric(...))
            ->map(static fn($saturation) => (int) $saturation)
            ->attempt(static fn() => new \DomainException("Saturation not found in '{$colour->toString()}'"))
            ->flatMap(Saturation::of(...));
        $lightness = $matches
            ->get('lightness')
            ->filter(\is_numeric(...))
            ->map(static fn($lightness) => (int) $lightness)
            ->attempt(static fn() => new \DomainException("Lightness not found in '{$colour->toString()}'"))
            ->flatMap(Lightness::of(...));
        $alpha = $matches
            ->get('alpha')
            ->filter(\is_numeric(...))
            ->map(static fn($alpha) => (float) $alpha)
            ->attempt(static fn() => new \DomainException("Alpha not found in '{$colour->toString()}'"))
            ->flatMap(Alpha::of(...));

        return $hue->flatMap(
            static fn($hue) => $saturation->flatMap(
                static fn($saturation) => $lightness->flatMap(
                    static fn($lightness) => $alpha->map(
                        static fn($alpha) => self::from(
                            $hue,
                            $saturation,
                            $lightness,
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
    private static function withoutAlpha(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::PATTERN_WITHOUT_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $hue = $matches
            ->get('hue')
            ->filter(\is_numeric(...))
            ->map(static fn($hue) => (int) $hue)
            ->attempt(static fn() => new \DomainException("Hue not found in '{$colour->toString()}'"))
            ->flatMap(Hue::of(...));
        $saturation = $matches
            ->get('saturation')
            ->filter(\is_numeric(...))
            ->map(static fn($saturation) => (int) $saturation)
            ->attempt(static fn() => new \DomainException("Saturation not found in '{$colour->toString()}'"))
            ->flatMap(Saturation::of(...));
        $lightness = $matches
            ->get('lightness')
            ->filter(\is_numeric(...))
            ->map(static fn($lightness) => (int) $lightness)
            ->attempt(static fn() => new \DomainException("Lightness not found in '{$colour->toString()}'"))
            ->flatMap(Lightness::of(...));

        return $hue->flatMap(
            static fn($hue) => $saturation->flatMap(
                static fn($saturation) => $lightness->map(
                    static fn($lightness) => self::from(
                        $hue,
                        $saturation,
                        $lightness,
                    ),
                ),
            ),
        );
    }
}
