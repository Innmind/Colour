<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Cyan
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
    public function add(self $cyan): self
    {
        return new self(
            \min(
                $this->value + $cyan->toInt(),
                100,
            ),
        );
    }

    #[\NoDiscard]
    public function subtract(self $cyan): self
    {
        return new self(
            \max(
                $this->value - $cyan->toInt(),
                0,
            ),
        );
    }

    #[\NoDiscard]
    public function equals(self $cyan): bool
    {
        return $this->value === $cyan->toInt();
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
