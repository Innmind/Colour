<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Alpha
{
    private float $value;
    private string $hexadecimal;

    public function __construct(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new InvalidValueRangeException;
        }

        $this->value = $value;
        $this->hexadecimal = str_pad(
            dechex(
                (int) round(255 * $this->value)
            ),
            2,
            '0',
            STR_PAD_LEFT
        );
    }

    public static function fromHexadecimal(string $hex): self
    {
        if (mb_strlen($hex) === 1) {
            $hex .= $hex;
        }

        return new self(round(hexdec($hex) / 255, 2));
    }

    public function add(self $alpha): self
    {
        return new self(
            min(
                $this->value + $alpha->toFloat(),
                1
            )
        );
    }

    public function subtract(self $alpha): self
    {
        return new self(
            max(
                $this->value - $alpha->toFloat(),
                0
            )
        );
    }

    public function equals(self $alpha): bool
    {
        return $this->value === $alpha->toFloat();
    }

    public function atMaximum(): bool
    {
        return $this->value === 1.0;
    }

    public function atMinimum(): bool
    {
        return $this->value === 0.0;
    }

    public function toFloat(): float
    {
        return $this->value;
    }

    public function toHexadecimal(): string
    {
        return $this->hexadecimal;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
