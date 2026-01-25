<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Alpha
{
    private float $value;

    private function __construct(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new \OutOfBoundsException((string) $value);
        }

        $this->value = $value;
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function max(): self
    {
        return new self(1);
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    #[\NoDiscard]
    public static function of(float $value): Attempt
    {
        return Attempt::of(static fn() => new self($value));
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    #[\NoDiscard]
    public static function fromHexadecimal(string $hex): Attempt
    {
        if (\mb_strlen($hex) === 1) {
            $hex .= $hex;
        }

        return self::of(\round(\hexdec($hex) / 255, 2));
    }

    #[\NoDiscard]
    public function add(self $alpha): self
    {
        return new self(
            \min(
                $this->value + $alpha->toFloat(),
                1,
            ),
        );
    }

    #[\NoDiscard]
    public function subtract(self $alpha): self
    {
        return new self(
            \max(
                $this->value - $alpha->toFloat(),
                0,
            ),
        );
    }

    #[\NoDiscard]
    public function equals(self $alpha): bool
    {
        return $this->value === $alpha->toFloat();
    }

    #[\NoDiscard]
    public function atMaximum(): bool
    {
        return $this->value === 1.0;
    }

    #[\NoDiscard]
    public function atMinimum(): bool
    {
        return $this->value === 0.0;
    }

    #[\NoDiscard]
    public function toFloat(): float
    {
        return $this->value;
    }

    #[\NoDiscard]
    public function toHexadecimal(): string
    {
        return \str_pad(
            \dechex(
                (int) \round(255 * $this->value),
            ),
            2,
            '0',
            \STR_PAD_LEFT,
        );
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return (string) $this->value;
    }
}
