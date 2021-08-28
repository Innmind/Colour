<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class HSLA
{
    private const PATTERN_WITH_ALPHA = '~^hsla\((?<hue>\d{1,3}), ?(?<saturation>\d{1,3})%, ?(?<lightness>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    private const PATTERN_WITHOUT_ALPHA = '~^hsl\((?<hue>\d{1,3}), ?(?<saturation>\d{1,3})%, ?(?<lightness>\d{1,3})%\)$~';

    private Hue $hue;
    private Saturation $saturation;
    private Lightness $lightness;
    private Alpha $alpha;
    private string $string;
    private ?RGBA $rgba = null;

    public function __construct(
        Hue $hue,
        Saturation $saturation,
        Lightness $lightness,
        Alpha $alpha = null
    ) {
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->lightness = $lightness;
        $this->alpha = $alpha ?? new Alpha(1);

        if ($this->alpha->atMaximum()) {
            $this->string = \sprintf(
                'hsl(%s, %s%%, %s%%)',
                $this->hue->toString(),
                $this->saturation->toString(),
                $this->lightness->toString(),
            );
        } else {
            $this->string = \sprintf(
                'hsla(%s, %s%%, %s%%, %s)',
                $this->hue->toString(),
                $this->saturation->toString(),
                $this->lightness->toString(),
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

        return self::withAlpha($colour)->otherwise(
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
        if ($this->rgba instanceof RGBA) {
            return $this->rgba;
        }

        $lightness = $this->lightness->toInt() / 100;

        if ($this->saturation->atMinimum()) {
            return $this->rgba = new RGBA(
                new Red((int) \round($lightness * 255)),
                new Green((int) \round($lightness * 255)),
                new Blue((int) \round($lightness * 255)),
                $this->alpha,
            );
        }

        $hue = $this->hue->toInt() / 360;
        $saturation = $this->saturation->toInt() / 100;

        //can't find a formula on internet where $q and $p are explained
        $q = $lightness < 0.5 ? $lightness * (1 + $saturation) : $lightness + $saturation - $lightness * $saturation;
        $p = 2 * $lightness - $q;

        return $this->rgba = new RGBA(
            new Red((int) \round($this->hueToPoint($p, $q, $hue + 1 / 3) * 255)),
            new Green((int) \round($this->hueToPoint($p, $q, $hue) * 255)),
            new Blue((int) \round($this->hueToPoint($p, $q, $hue - 1 / 3) * 255)),
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
        return $this->string;
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
     * @return Maybe<self>
     */
    private static function withAlpha(Str $colour): Maybe
    {
        if (!$colour->matches(self::PATTERN_WITH_ALPHA)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::PATTERN_WITH_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $hue = $matches
            ->get('hue')
            ->filter(static fn($hue) => \is_numeric($hue))
            ->map(static fn($hue) => (int) $hue)
            ->flatMap(static fn($hue) => Hue::of($hue));
        $saturation = $matches
            ->get('saturation')
            ->filter(static fn($saturation) => \is_numeric($saturation))
            ->map(static fn($saturation) => (int) $saturation)
            ->flatMap(static fn($saturation) => Saturation::of($saturation));
        $lightness = $matches
            ->get('lightness')
            ->filter(static fn($lightness) => \is_numeric($lightness))
            ->map(static fn($lightness) => (int) $lightness)
            ->flatMap(static fn($lightness) => Lightness::of($lightness));
        $alpha = $matches
            ->get('alpha')
            ->filter(static fn($alpha) => \is_numeric($alpha))
            ->map(static fn($alpha) => (float) $alpha)
            ->flatMap(static fn($alpha) => Alpha::of($alpha));

        return Maybe::all($hue, $saturation, $lightness, $alpha)->map(
            static fn(Hue $hue, Saturation $saturation, Lightness $lightness, Alpha $alpha) => new self(
                $hue,
                $saturation,
                $lightness,
                $alpha,
            ),
        );
    }

    /**
     * @return Maybe<self>
     */
    private static function withoutAlpha(Str $colour): Maybe
    {
        if (!$colour->matches(self::PATTERN_WITHOUT_ALPHA)) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        $matches = $colour
            ->capture(self::PATTERN_WITHOUT_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $hue = $matches
            ->get('hue')
            ->filter(static fn($hue) => \is_numeric($hue))
            ->map(static fn($hue) => (int) $hue)
            ->flatMap(static fn($hue) => Hue::of($hue));
        $saturation = $matches
            ->get('saturation')
            ->filter(static fn($saturation) => \is_numeric($saturation))
            ->map(static fn($saturation) => (int) $saturation)
            ->flatMap(static fn($saturation) => Saturation::of($saturation));
        $lightness = $matches
            ->get('lightness')
            ->filter(static fn($lightness) => \is_numeric($lightness))
            ->map(static fn($lightness) => (int) $lightness)
            ->flatMap(static fn($lightness) => Lightness::of($lightness));

        return Maybe::all($hue, $saturation, $lightness)->map(
            static fn(Hue $hue, Saturation $saturation, Lightness $lightness) => new self(
                $hue,
                $saturation,
                $lightness,
            ),
        );
    }
}
