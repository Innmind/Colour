<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Lightness
{
    /**
     * @param int<0, 100> $value
     */
    private function __construct(
        private int $value,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, 100> $value
     */
    #[\NoDiscard]
    public static function at(int $value): self
    {
        return new self($value);
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    #[\NoDiscard]
    public static function of(int $value): Attempt
    {
        if ($value < 0 || $value > 100) {
            return Attempt::error(new \OutOfBoundsException((string) $value));
        }

        return Attempt::result(new self($value));
    }

    #[\NoDiscard]
    public function add(self $lightness): self
    {
        return new self(
            \min(
                $this->value + $lightness->toInt(),
                100,
            ),
        );
    }

    #[\NoDiscard]
    public function subtract(self $lightness): self
    {
        return new self(
            \max(
                $this->value - $lightness->toInt(),
                0,
            ),
        );
    }

    #[\NoDiscard]
    public function equals(self $lightness): bool
    {
        return $this->value === $lightness->toInt();
    }

    #[\NoDiscard]
    public function atMaximum(): bool
    {
        return $this->value === 100;
    }

    #[\NoDiscard]
    public function atMinimum(): bool
    {
        return $this->value === 0;
    }

    /**
     * @return int<0, 100>
     */
    #[\NoDiscard]
    public function toInt(): int
    {
        return $this->value;
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return (string) $this->value;
    }
}
