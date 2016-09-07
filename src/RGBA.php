<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class RGBA
{
    const HEXADECIMAL_PATTERN_WITH_ALPHA = '~^#?(?<red>[0-9a-fA-F]{1,2})(?<green>[0-9a-fA-F]{1,2})(?<blue>[0-9a-fA-F]{1,2})(?<alpha>[0-9a-fA-F]{1,2})$~';
    const HEXADECIMAL_PATTERN_WITHOUT_ALPHA = '~^#?(?<red>[0-9a-fA-F]{1,2})(?<green>[0-9a-fA-F]{1,2})(?<blue>[0-9a-fA-F]{1,2})$~';
    const RGB_FUNCTION_PATTERN = '~^rgb\((?<red>\d{1,3}), ?(?<green>\d{1,3}), ?(?<blue>\d{1,3})\)$~';
    const PERCENTED_RGB_FUNCTION_PATTERN = '~^rgb\((?<red>\d{1,3})%, ?(?<green>\d{1,3})%, ?(?<blue>\d{1,3})%\)$~';
    const RGBA_FUNCTION_PATTERN = '~^rgba\((?<red>\d{1,3}), ?(?<green>\d{1,3}), ?(?<blue>\d{1,3}), ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    const PERCENTED_RGBA_FUNCTION_PATTERN = '~^rgba\((?<red>\d{1,3})%, ?(?<green>\d{1,3})%, ?(?<blue>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';

    private $red;
    private $blue;
    private $green;
    private $alpha;
    private $string;

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
            $this->string = sprintf(
                'rgba(%s, %s, %s, %s)',
                $this->red->toInt(),
                $this->green->toInt(),
                $this->blue->toInt(),
                $this->alpha->toFloat()
            );
        }
    }

    public static function fromHexadecimal(string $colour): self
    {
        $colour = (new Str($colour))->trim();

        try {
            return self::fromHexadecimalWithAlpha($colour);
        } catch (InvalidArgumentException $e) {
            return self::fromHexadecimalWithoutAlpha($colour);
        }
    }

    public static function fromHexadecimalWithAlpha(Str $colour): self
    {
        if (!$colour->match(self::HEXADECIMAL_PATTERN_WITH_ALPHA)) {
            throw new InvalidArgumentException;
        }

        if ($colour->match('/^#/')) {
            $colour = $colour->substring(1);
        }

        if (
            $colour->length() !== 4 &&
            $colour->length() !== 8
        ) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::HEXADECIMAL_PATTERN_WITH_ALPHA);

        return new self(
            Red::fromHexadecimal((string) $matches->get('red')),
            Green::fromHexadecimal((string) $matches->get('green')),
            Blue::fromHexadecimal((string) $matches->get('blue')),
            Alpha::fromHexadecimal((string) $matches->get('alpha'))
        );
    }

    public static function fromHexadecimalWithoutAlpha(Str $colour): self
    {
        if (!$colour->match(self::HEXADECIMAL_PATTERN_WITHOUT_ALPHA)) {
            throw new InvalidArgumentException;
        }

        if ($colour->match('/^#/')) {
            $colour = $colour->substring(1);
        }

        if (
            $colour->length() !== 3 &&
            $colour->length() !== 6
        ) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::HEXADECIMAL_PATTERN_WITHOUT_ALPHA);

        return new self(
            Red::fromHexadecimal((string) $matches->get('red')),
            Green::fromHexadecimal((string) $matches->get('green')),
            Blue::fromHexadecimal((string) $matches->get('blue'))
        );
    }

    public static function fromRGBFunction(string $colour): self
    {
        $colour = (new Str($colour))->trim();

        try {
            return self::fromRGBFunctionWithPoints($colour);
        } catch (InvalidArgumentException $e) {
            return self::fromRGBFunctionWithPercents($colour);
        }
    }

    public static function fromRGBFunctionWithPoints(Str $colour): self
    {
        if (!$colour->match(self::RGB_FUNCTION_PATTERN)) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::RGB_FUNCTION_PATTERN);

        return new self(
            new Red((int) (string) $matches->get('red')),
            new Green((int) (string) $matches->get('green')),
            new Blue((int) (string) $matches->get('blue'))
        );
    }

    public static function fromRGBFunctionWithPercents(Str $colour): self
    {
        if (!$colour->match(self::PERCENTED_RGB_FUNCTION_PATTERN)) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::PERCENTED_RGB_FUNCTION_PATTERN);

        return new self(
            Red::fromIntensity(new Intensity((int) (string) $matches->get('red'))),
            Green::fromIntensity(new Intensity((int) (string) $matches->get('green'))),
            Blue::fromIntensity(new Intensity((int) (string) $matches->get('blue')))
        );
    }

    public static function fromRGBAFunction(string $colour): self
    {
        $colour = (new Str($colour))->trim();

        try {
            return self::fromRGBAFunctionWithPoints($colour);
        } catch (InvalidArgumentException $e) {
            return self::fromRGBAFunctionWithPercents($colour);
        }
    }

    public static function fromRGBAFunctionWithPoints(Str $colour): self
    {
        if (!$colour->match(self::RGBA_FUNCTION_PATTERN)) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::RGBA_FUNCTION_PATTERN);

        return new self(
            new Red((int) (string) $matches->get('red')),
            new Green((int) (string) $matches->get('green')),
            new Blue((int) (string) $matches->get('blue')),
            new Alpha((float) (string) $matches->get('alpha'))
        );
    }

    public static function fromRGBAFunctionWithPercents(Str $colour): self
    {
        if (!$colour->match(self::PERCENTED_RGBA_FUNCTION_PATTERN)) {
            throw new InvalidArgumentException;
        }

        $matches = $colour->getMatches(self::PERCENTED_RGBA_FUNCTION_PATTERN);

        return new self(
            Red::fromIntensity(new Intensity((int) (string) $matches->get('red'))),
            Green::fromIntensity(new Intensity((int) (string) $matches->get('green'))),
            Blue::fromIntensity(new Intensity((int) (string) $matches->get('blue'))),
            new Alpha((float) (string) $matches->get('alpha'))
        );
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
            $this->alpha
        );
    }

    public function subtractRed(Red $red): self
    {
        return new self(
            $this->red->subtract($red),
            $this->green,
            $this->blue,
            $this->alpha
        );
    }

    public function addBlue(Blue $blue): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue->add($blue),
            $this->alpha
        );
    }

    public function subtractBlue(Blue $blue): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue->subtract($blue),
            $this->alpha
        );
    }

    public function addGreen(Green $green): self
    {
        return new self(
            $this->red,
            $this->green->add($green),
            $this->blue,
            $this->alpha
        );
    }

    public function subtractGreen(Green $green): self
    {
        return new self(
            $this->red,
            $this->green->subtract($green),
            $this->blue,
            $this->alpha
        );
    }

    public function addAlpha(Alpha $alpha): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue,
            $this->alpha->add($alpha)
        );
    }

    public function subtractAlpha(Alpha $alpha): self
    {
        return new self(
            $this->red,
            $this->green,
            $this->blue,
            $this->alpha->subtract($alpha)
        );
    }

    public function toHexadecimal(): string
    {
        $hex = $this->red.$this->green.$this->blue;

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
