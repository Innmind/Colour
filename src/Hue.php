<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Hue
{
    /**
     * @param int<0, 359> $value
     */
    private function __construct(
        private int $value,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, 359> $value
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
        if ($value < 0 || $value > 359) {
            return Attempt::error(new \OutOfBoundsException((string) $value));
        }

        return Attempt::result(new self($value));
    }

    public function rotateBy(int $degrees): self
    {
        $degrees = ($this->value + $degrees) % 360;

        if ($degrees < 0) {
            return new self(360 + $degrees);
        }

        return new self($degrees);
    }

    public function opposite(): self
    {
        return $this->rotateBy(180);
    }

    public function equals(self $hue): bool
    {
        return $this->value === $hue->toInt();
    }

    public function atMaximum(): bool
    {
        return $this->value === 359;
    }

    public function atMinimum(): bool
    {
        return $this->value === 0;
    }

    /**
     * @return int<0, 359>
     */
    public function toInt(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }
}
