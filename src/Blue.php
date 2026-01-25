<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Blue
{
    /**
     * @param int<0, 255> $integer
     */
    private function __construct(
        private int $integer,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, 255> $value
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
        if ($value < 0 || $value > 255) {
            return Attempt::error(new \OutOfBoundsException((string) $value));
        }

        return Attempt::result(new self($value));
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    public static function fromHexadecimal(string $hex): Attempt
    {
        if (\mb_strlen($hex) === 1) {
            $hex .= $hex;
        }

        return self::of((int) \hexdec($hex));
    }

    /**
     * @return Attempt<self>
     */
    public static function fromIntensity(Intensity $intensity): Attempt
    {
        return self::of(
            (int) \round((255 * $intensity->toInt()) / 100),
        );
    }

    public function add(self $blue): self
    {
        return new self(
            \min(
                $this->integer + $blue->toInt(),
                255,
            ),
        );
    }

    public function subtract(self $blue): self
    {
        return new self(
            \max(
                $this->integer - $blue->toInt(),
                0,
            ),
        );
    }

    public function equals(self $blue): bool
    {
        return $this->integer === $blue->toInt();
    }

    public function atMaximum(): bool
    {
        return $this->integer === 255;
    }

    public function atMinimum(): bool
    {
        return $this->integer === 0;
    }

    /**
     * @return int<0, 255>
     */
    public function toInt(): int
    {
        return $this->integer;
    }

    public function toString(): string
    {
        return \str_pad(
            \dechex($this->integer),
            2,
            '0',
            \STR_PAD_LEFT,
        );
    }
}
