<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Saturation
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidValueRangeException;
        }

        $this->value = $value;
    }

    public function add(self $saturation): self
    {
        return new self(
            \min(
                $this->value + $saturation->toInt(),
                100,
            ),
        );
    }

    public function subtract(self $saturation): self
    {
        return new self(
            \max(
                $this->value - $saturation->toInt(),
                0,
            ),
        );
    }

    public function equals(self $saturation): bool
    {
        return $this->value === $saturation->toInt();
    }

    public function atMaximum(): bool
    {
        return $this->value === 100;
    }

    public function atMinimum(): bool
    {
        return $this->value === 0;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
