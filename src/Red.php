<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\Attempt;

/**
 * @psalm-immutable
 */
final class Red
{
    private int $integer;

    private function __construct(int $integer)
    {
        if ($integer < 0 || $integer > 255) {
            throw new \OutOfBoundsException((string) $integer);
        }

        $this->integer = $integer;
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
        return Attempt::of(static fn() => new self($value));
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
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    public static function fromIntensity(Intensity $intensity): Attempt
    {
        return self::of(
            (int) \round((255 * $intensity->toInt()) / 100),
        );
    }

    public function add(self $red): self
    {
        return new self(
            \min(
                $this->integer + $red->toInt(),
                255,
            ),
        );
    }

    public function subtract(self $red): self
    {
        return new self(
            \max(
                $this->integer - $red->toInt(),
                0,
            ),
        );
    }

    public function equals(self $red): bool
    {
        return $this->integer === $red->toInt();
    }

    public function atMaximum(): bool
    {
        return $this->integer === 255;
    }

    public function atMinimum(): bool
    {
        return $this->integer === 0;
    }

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
