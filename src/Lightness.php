<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Lightness
{
    private int $value;

    private function __construct(int $value)
    {
        if ($value < 0 || $value > 100) {
            throw new \OutOfBoundsException((string) $value);
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

    public function add(self $lightness): self
    {
        return new self(
            \min(
                $this->value + $lightness->toInt(),
                100,
            ),
        );
    }

    public function subtract(self $lightness): self
    {
        return new self(
            \max(
                $this->value - $lightness->toInt(),
                0,
            ),
        );
    }

    public function equals(self $lightness): bool
    {
        return $this->value === $lightness->toInt();
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
