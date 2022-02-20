<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Colour\Exception\InvalidValueRangeException;
use Innmind\Immutable\Maybe;

final class Green
{
    private int $integer;

    public function __construct(int $integer)
    {
        if ($integer < 0 || $integer > 255) {
            throw new InvalidValueRangeException((string) $integer);
        }

        $this->integer = $integer;
    }

    /**
     * @return Maybe<self>
     */
    public static function of(int $value): Maybe
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

        return self::of((int) \hexdec($hex));
    }

    /**
     * @return Maybe<self>
     */
    public static function fromIntensity(Intensity $intensity): Maybe
    {
        return self::of(
            (int) \round((255 * $intensity->toInt()) / 100),
        );
    }

    public function add(self $green): self
    {
        return new self(
            \min(
                $this->integer + $green->toInt(),
                255,
            ),
        );
    }

    public function subtract(self $green): self
    {
        return new self(
            \max(
                $this->integer - $green->toInt(),
                0,
            ),
        );
    }

    public function equals(self $green): bool
    {
        return $this->integer === $green->toInt();
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
