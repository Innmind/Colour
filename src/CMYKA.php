<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class CMYKA
{
    const PATTERN_WITH_ALPHA = '~^device-cmyk\((?<cyan>\d{1,3})%, ?(?<magenta>\d{1,3})%, ?(?<yellow>\d{1,3})%, ?(?<black>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    const PATTERN_WITHOUT_ALPHA = '~^device-cmyk\((?<cyan>\d{1,3})%, ?(?<magenta>\d{1,3})%, ?(?<yellow>\d{1,3})%, ?(?<black>\d{1,3})%\)$~';

    private $cyan;
    private $magenta;
    private $yellow;
    private $black;
    private $alpha;
    private $string;

    public function __construct(
        Cyan $cyan,
        Magenta $magenta,
        Yellow $yellow,
        Black $black,
        Alpha $alpha = null
    ) {
        $this->cyan = $cyan;
        $this->magenta = $magenta;
        $this->yellow = $yellow;
        $this->black = $black;
        $this->alpha = $alpha ?? new Alpha(1);

        if ($this->alpha->atMaximum()) {
            $this->string = sprintf(
                'device-cmyk(%s%%, %s%%, %s%%, %s%%)',
                $this->cyan,
                $this->magenta,
                $this->yellow,
                $this->black
            );
        } else {
            $this->string = sprintf(
                'device-cmyk(%s%%, %s%%, %s%%, %s%%, %s)',
                $this->cyan,
                $this->magenta,
                $this->yellow,
                $this->black,
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
            new Cyan((int) (string) $matches->get('cyan')),
            new Magenta((int) (string) $matches->get('magenta')),
            new Yellow((int) (string) $matches->get('yellow')),
            new Black((int) (string) $matches->get('black')),
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
            new Cyan((int) (string) $matches->get('cyan')),
            new Magenta((int) (string) $matches->get('magenta')),
            new Yellow((int) (string) $matches->get('yellow')),
            new Black((int) (string) $matches->get('black'))
        );
    }

    public function cyan(): Cyan
    {
        return $this->cyan;
    }

    public function magenta(): Magenta
    {
        return $this->magenta;
    }

    public function yellow(): Yellow
    {
        return $this->yellow;
    }

    public function black(): Black
    {
        return $this->black;
    }

    public function alpha(): Alpha
    {
        return $this->alpha;
    }

    public function addCyan(Cyan $cyan): self
    {
        return new self(
            $this->cyan->add($cyan),
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha
        );
    }

    public function subtractCyan(Cyan $cyan): self
    {
        return new self(
            $this->cyan->subtract($cyan),
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha
        );
    }

    public function addMagenta(Magenta $magenta): self
    {
        return new self(
            $this->cyan,
            $this->magenta->add($magenta),
            $this->yellow,
            $this->black,
            $this->alpha
        );
    }

    public function subtractMagenta(Magenta $magenta): self
    {
        return new self(
            $this->cyan,
            $this->magenta->subtract($magenta),
            $this->yellow,
            $this->black,
            $this->alpha
        );
    }

    public function addYellow(Yellow $yellow): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow->add($yellow),
            $this->black,
            $this->alpha
        );
    }

    public function subtractYellow(Yellow $yellow): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow->subtract($yellow),
            $this->black,
            $this->alpha
        );
    }

    public function addBlack(Black $black): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black->add($black),
            $this->alpha
        );
    }

    public function subtractBlack(Black $black): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black->subtract($black),
            $this->alpha
        );
    }

    public function addAlpha(Alpha $alpha): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha->add($alpha)
        );
    }

    public function subtractAlpha(Alpha $alpha): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha->subtract($alpha)
        );
    }

    public function __toString(): string
    {
        return $this->string;
    }
}