<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Magenta
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidValueRangeException;
        }

        $this->value = $value;
    }

    public function add(self $magenta): self
    {
        return new self(
            min(
                $this->value + $magenta->toInt(),
                100
            )
        );
    }

    public function subtract(self $magenta): self
    {
        return new self(
            max(
                $this->value - $magenta->toInt(),
                0
            )
        );
    }

    public function equals(self $magenta): bool
    {
        return $this->value === $magenta->toInt();
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
