<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Black
{
    private $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidValueRangeException;
        }

        $this->value = $value;
    }

    public function add(self $black): self
    {
        return new self(
            min(
                $this->value + $black->toInt(),
                100
            )
        );
    }

    public function subtract(self $black): self
    {
        return new self(
            max(
                $this->value - $black->toInt(),
                0
            )
        );
    }

    public function equals(self $black): bool
    {
        return $this->value === $black->toInt();
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
