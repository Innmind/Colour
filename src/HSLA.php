<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class HSLA
{
    const PATTERN_WITH_ALPHA = '~^hsla\((?<hue>\d{1,3}), ?(?<saturation>\d{1,3})%, ?(?<lightness>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    const PATTERN_WITHOUT_ALPHA = '~^hsl\((?<hue>\d{1,3}), ?(?<saturation>\d{1,3})%, ?(?<lightness>\d{1,3})%\)$~';

    private $hue;
    private $saturation;
    private $lightness;
    private $alpha;
    private $string;

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
            $this->string = sprintf(
                'hsl(%s, %s%%, %s%%)',
                $this->hue,
                $this->saturation,
                $this->lightness
            );
        } else {
            $this->string = sprintf(
                'hsla(%s, %s%%, %s%%, %s)',
                $this->hue,
                $this->saturation,
                $this->lightness,
                $this->alpha->toFloat()
            );
        }
    }

    public static function fromString(string $colour): self
    {
        $colour = (new Str($colour))->trim();

        try {
            return self::fromStringWithAlpha($colour);
        } catch (InvalidArgumentException $e) {
            return self::fromStringWithoutAlpha($colour);
        }
    }

    public static function fromStringWithAlpha(Str $colour): self
    {
        if (!$colour->match(self::PATTERN_WITH_ALPHA)) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::PATTERN_WITH_ALPHA);

        return new self(
            new Hue((int) (string) $matches->get('hue')),
            new Saturation((int) (string) $matches->get('saturation')),
            new Lightness((int) (string) $matches->get('lightness')),
            new Alpha((float) (string) $matches->get('alpha'))
        );
    }

    public static function fromStringWithoutAlpha(Str $colour): self
    {
        if (!$colour->match(self::PATTERN_WITHOUT_ALPHA)) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::PATTERN_WITHOUT_ALPHA);

        return new self(
            new Hue((int) (string) $matches->get('hue')),
            new Saturation((int) (string) $matches->get('saturation')),
            new Lightness((int) (string) $matches->get('lightness'))
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
            $this->alpha
        );
    }

    public function addSaturation(Saturation $saturation): self
    {
        return new self(
            $this->hue,
            $this->saturation->add($saturation),
            $this->lightness,
            $this->alpha
        );
    }

    public function subtractSaturation(Saturation $saturation): self
    {
        return new self(
            $this->hue,
            $this->saturation->subtract($saturation),
            $this->lightness,
            $this->alpha
        );
    }

    public function addLightness(Lightness $lightness): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness->add($lightness),
            $this->alpha
        );
    }

    public function subtractLightness(Lightness $lightness): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness->subtract($lightness),
            $this->alpha
        );
    }

    public function addAlpha(Alpha $alpha): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness,
            $this->alpha->add($alpha)
        );
    }

    public function subtractAlpha(Alpha $alpha): self
    {
        return new self(
            $this->hue,
            $this->saturation,
            $this->lightness,
            $this->alpha->subtract($alpha)
        );
    }

    public function equals(self $hsla): bool
    {
        return $this->hue->equals($hsla->hue()) &&
            $this->saturation->equals($hsla->saturation()) &&
            $this->lightness->equals($hsla->lightness()) &&
            $this->alpha->equals($hsla->alpha());
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
