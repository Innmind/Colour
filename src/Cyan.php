<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;

final class Cyan
{
    private $value;

    public function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidValueRangeException;
        }

        $this->value = $value;
    }

    public function add(self $cyan): self
    {
        return new self(
            min(
                $this->value + $cyan->toInt(),
                100
            )
        );
    }

    public function subtract(self $cyan): self
    {
        return new self(
            max(
                $this->value - $cyan->toInt(),
                0
            )
        );
    }

    public function equals(self $cyan): bool
    {
        return $this->value === $cyan->toInt();
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
