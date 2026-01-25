<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Yellow
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
    public function add(self $yellow): self
    {
        return new self(
            \min(
                $this->value + $yellow->toInt(),
                100,
            ),
        );
    }

    #[\NoDiscard]
    public function subtract(self $yellow): self
    {
        return new self(
            \max(
                $this->value - $yellow->toInt(),
                0,
            ),
        );
    }

    #[\NoDiscard]
    public function equals(self $yellow): bool
    {
        return $this->value === $yellow->toInt();
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
