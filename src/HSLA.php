<?php
declare(strict_types = 1);

namespace Innmind\Colour;

final class HSLA
{
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

    public function __toString(): string
    {
        return $this->string;
    }
}
