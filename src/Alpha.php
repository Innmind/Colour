<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;
use Innmind\Immutable\Maybe;

final class Alpha
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new InvalidValueRangeException((string) $value);
        }

        $this->value = $value;
    }

    /**
     * @return Maybe<self>
     */
    public static function of(float $value): Maybe
    {
        try {
            return Maybe::just(new self($value));
        } catch (InvalidValueRangeException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    /**
     * @return Maybe<self>
     */
    public static function fromHexadecimal(string $hex): Maybe
    {
        if (\mb_strlen($hex) === 1) {
            $hex .= $hex;
        }

        return self::of(\round(\hexdec($hex) / 255, 2));
    }

    public function add(self $alpha): self
    {
        return new self(
            \min(
                $this->value + $alpha->toFloat(),
                1,
            ),
        );
    }

    public function subtract(self $alpha): self
    {
        return new self(
            \max(
                $this->value - $alpha->toFloat(),
                0,
            ),
        );
    }

    public function equals(self $alpha): bool
    {
        return $this->value === $alpha->toFloat();
    }

    public function atMaximum(): bool
    {
        return $this->value === 1.0;
    }

    public function atMinimum(): bool
    {
        return $this->value === 0.0;
    }

    public function toFloat(): float
    {
        return $this->value;
    }

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

    public function toString(): string
    {
        return (string) $this->value;
    }
}
