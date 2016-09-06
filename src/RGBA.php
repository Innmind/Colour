<?php
declare(strict_types = 1);

namespace Innmind\Colour;

final class RGBA
{
    private $red;
    private $blue;
    private $green;
    private $alpha;
    private $string;

    public function __construct(
        Red $red,
        Blue $blue,
        Green $green,
        Alpha $alpha = null
    ) {
        $this->red = $red;
        $this->blue = $blue;
        $this->green = $green;
        $this->alpha = $alpha ?? new Alpha(1);

        if ($this->alpha->atMaximum()) {
            $this->string = '#'.$this->toHexadecimal();
        } else {
            $this->string = sprintf(
                'rgba(%s, %s, %s, %s)',
                $this->red->toInt(),
                $this->blue->toInt(),
                $this->green->toInt(),
                $this->alpha->toFloat()
            );
        }
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
            $this->blue,
            $this->green,
            $this->alpha
        );
    }

    public function subtractRed(Red $red): self
    {
        return new self(
            $this->red->subtract($red),
            $this->blue,
            $this->green,
            $this->alpha
        );
    }

    public function addBlue(Blue $blue): self
    {
        return new self(
            $this->red,
            $this->blue->add($blue),
            $this->green,
            $this->alpha
        );
    }

    public function subtractBlue(Blue $blue): self
    {
        return new self(
            $this->red,
            $this->blue->subtract($blue),
            $this->green,
            $this->alpha
        );
    }

    public function addGreen(Green $green): self
    {
        return new self(
            $this->red,
            $this->blue,
            $this->green->add($green),
            $this->alpha
        );
    }

    public function subtractGreen(Green $green): self
    {
        return new self(
            $this->red,
            $this->blue,
            $this->green->subtract($green),
            $this->alpha
        );
    }

    public function addAlpha(Alpha $alpha): self
    {
        return new self(
            $this->red,
            $this->blue,
            $this->green,
            $this->alpha->add($alpha)
        );
    }

    public function subtractAlpha(Alpha $alpha): self
    {
        return new self(
            $this->red,
            $this->blue,
            $this->green,
            $this->alpha->subtract($alpha)
        );
    }

    public function toHexadecimal(): string
    {
        $hex = $this->red.$this->blue.$this->green;

        if (!$this->alpha->atMaximum()) {
            $hex .= $this->alpha()->toHexadecimal();
        }

        return $hex;
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
