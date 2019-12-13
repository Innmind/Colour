<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Cyan
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidValueRangeException((string) $value);
        }

        $this->value = $value;
    }

    public function add(self $cyan): self
    {
        return new self(
            \min(
                $this->value + $cyan->toInt(),
                100,
            ),
        );
    }

    public function subtract(self $cyan): self
    {
        return new self(
            \max(
                $this->value - $cyan->toInt(),
                0,
            ),
        );
    }

    public function equals(self $cyan): bool
    {
        return $this->value === $cyan->toInt();
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

    public function toString(): string
    {
        return (string) $this->value;
    }
}
