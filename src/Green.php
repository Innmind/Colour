<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Green
{
    private int $integer;
    private string $hexadecimal;

    public function __construct(int $integer)
    {
        if ($integer < 0 || $integer > 255) {
            throw new InvalidValueRangeException;
        }

        $this->integer = $integer;
        $this->hexadecimal = \str_pad(
            \dechex($integer),
            2,
            '0',
            STR_PAD_LEFT,
        );
    }

    public static function fromHexadecimal(string $hex): self
    {
        if (\mb_strlen($hex) === 1) {
            $hex .= $hex;
        }

        return new self(\hexdec($hex));
    }

    public static function fromIntensity(Intensity $intensity): self
    {
        return new self(
            (int) \round((255 * $intensity->toInt()) / 100),
        );
    }

    public function add(self $green): self
    {
        return new self(
            \min(
                $this->integer + $green->toInt(),
                255,
            ),
        );
    }

    public function subtract(self $green): self
    {
        return new self(
            \max(
                $this->integer - $green->toInt(),
                0,
            ),
        );
    }

    public function equals(self $green): bool
    {
        return $this->integer === $green->toInt();
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
