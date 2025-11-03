<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;
use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Saturation
{
    private int $value;

    /**
     * @throws InvalidValueRangeException
     */
    private function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidValueRangeException((string) $value);
        }

        $this->value = $value;
    }

    /**
     * @psalm-pure
     *
     * @param int<0, 100> $value
     */
    public static function at(int $value): self
    {
        return new self($value);
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    public static function of(int $value): Attempt
    {
        return Attempt::of(static fn() => new self($value));
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

    public function toString(): string
    {
        return (string) $this->value;
    }
}
