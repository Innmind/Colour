<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Red
{
    private $integer;
    private $hexadecimal;

    public function __construct(int $integer)
    {
        if ($integer < 0 || $integer > 255) {
            throw new InvalidValueRangeException;
        }

        $this->integer = $integer;
        $this->hexadecimal = dechex($integer);

        if (mb_strlen($this->hexadecimal) === 1) {
            $this->hexadecimal .= $this->hexadecimal;
        }
    }

    public static function fromHexadecimal(string $hex): self
    {
        if (mb_strlen($hex) === 1) {
            $hex .= $hex;
        }

        return new self(hexdec($hex));
    }

    public static function fromIntensity(Intensity $intensity): self
    {
        return new self(
            (int) round((255 * $intensity->toInt()) / 100)
        );
    }

    public function add(self $red): self
    {
        return new self(
            min(
                $this->integer + $red->toInt(),
                255
            )
        );
    }

    public function subtract(self $red): self
    {
        return new self(
            max(
                $this->integer - $red->toInt(),
                0
            )
        );
    }

    public function atMaximum(): bool
    {
        return $this->integer === 255;
    }

    public function atMinimum(): bool
    {
        return $this->integer === 0;
    }

    public function toInt(): int
    {
        return $this->integer;
    }

    public function __toString(): string
    {
        return $this->hexadecimal;
    }
}
