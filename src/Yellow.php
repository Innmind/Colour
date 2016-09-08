<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Yellow
{
    private $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidValueRangeException;
        }

        $this->value = $value;
    }

    public function add(self $yellow): self
    {
        return new self(
            min(
                $this->value + $yellow->toInt(),
                100
            )
        );
    }

    public function subtract(self $yellow): self
    {
        return new self(
            max(
                $this->value - $yellow->toInt(),
                0
            )
        );
    }

    public function equals(self $yellow): bool
    {
        return $this->value === $yellow->toInt();
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
