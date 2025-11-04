<?php
declare(strict_types = 1);

namespace Innmind\Colour;

use Innmind\Immutable\{
    Str,
    Maybe,
    Attempt,
};

/**
 * @psalm-immutable
 */
final class CMYKA
{
    private const PATTERN_WITH_ALPHA = '~^device-cmyk\((?<cyan>\d{1,3})%, ?(?<magenta>\d{1,3})%, ?(?<yellow>\d{1,3})%, ?(?<black>\d{1,3})%, ?(?<alpha>[01]|0?\.\d+|1\.0)\)$~';
    private const PATTERN_WITHOUT_ALPHA = '~^device-cmyk\((?<cyan>\d{1,3})%, ?(?<magenta>\d{1,3})%, ?(?<yellow>\d{1,3})%, ?(?<black>\d{1,3})%\)$~';

    private Cyan $cyan;
    private Magenta $magenta;
    private Yellow $yellow;
    private Black $black;
    private Alpha $alpha;

    private function __construct(
        Cyan $cyan,
        Magenta $magenta,
        Yellow $yellow,
        Black $black,
        Alpha $alpha,
    ) {
        $this->cyan = $cyan;
        $this->magenta = $magenta;
        $this->yellow = $yellow;
        $this->black = $black;
        $this->alpha = $alpha;
    }

    /**
     * @psalm-pure
     */
    public static function from(
        Cyan $cyan,
        Magenta $magenta,
        Yellow $yellow,
        Black $black,
        ?Alpha $alpha = null,
    ): self {
        return new self($cyan, $magenta, $yellow, $black, $alpha ?? Alpha::max());
    }

    /**
     * @psalm-pure
     *
     * @throws \Exception
     */
    public static function of(string $colour): self
    {
        return self::attempt($colour)->unwrap();
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $colour): Maybe
    {
        return self::attempt($colour)->maybe();
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    public static function attempt(string $colour): Attempt
    {
        $colour = Str::of($colour)->trim();

        return self::withAlpha($colour)->recover(
            static fn() => self::withoutAlpha($colour),
        );
    }

    public function cyan(): Cyan
    {
        return $this->cyan;
    }

    public function magenta(): Magenta
    {
        return $this->magenta;
    }

    public function yellow(): Yellow
    {
        return $this->yellow;
    }

    public function black(): Black
    {
        return $this->black;
    }

    public function alpha(): Alpha
    {
        return $this->alpha;
    }

    public function addCyan(Cyan $cyan): self
    {
        return new self(
            $this->cyan->add($cyan),
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha,
        );
    }

    public function subtractCyan(Cyan $cyan): self
    {
        return new self(
            $this->cyan->subtract($cyan),
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha,
        );
    }

    public function addMagenta(Magenta $magenta): self
    {
        return new self(
            $this->cyan,
            $this->magenta->add($magenta),
            $this->yellow,
            $this->black,
            $this->alpha,
        );
    }

    public function subtractMagenta(Magenta $magenta): self
    {
        return new self(
            $this->cyan,
            $this->magenta->subtract($magenta),
            $this->yellow,
            $this->black,
            $this->alpha,
        );
    }

    public function addYellow(Yellow $yellow): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow->add($yellow),
            $this->black,
            $this->alpha,
        );
    }

    public function subtractYellow(Yellow $yellow): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow->subtract($yellow),
            $this->black,
            $this->alpha,
        );
    }

    public function addBlack(Black $black): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black->add($black),
            $this->alpha,
        );
    }

    public function subtractBlack(Black $black): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black->subtract($black),
            $this->alpha,
        );
    }

    public function addAlpha(Alpha $alpha): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha->add($alpha),
        );
    }

    public function subtractAlpha(Alpha $alpha): self
    {
        return new self(
            $this->cyan,
            $this->magenta,
            $this->yellow,
            $this->black,
            $this->alpha->subtract($alpha),
        );
    }

    public function equals(self $cmyka): bool
    {
        return $this->cyan->equals($cmyka->cyan()) &&
            $this->magenta->equals($cmyka->magenta()) &&
            $this->yellow->equals($cmyka->yellow()) &&
            $this->black->equals($cmyka->black()) &&
            $this->alpha->equals($cmyka->alpha());
    }

    public function toRGBA(): RGBA
    {
        $cyan = $this->cyan->toInt() / 100;
        $magenta = $this->magenta->toInt() / 100;
        $yellow = $this->yellow->toInt() / 100;
        $black = $this->black->toInt() / 100;

        $red = 1 - \min(1, $cyan * (1 - $black) + $black);
        $green = 1 - \min(1, $magenta * (1 - $black) + $black);
        $blue = 1 - \min(1, $yellow * (1 - $black) + $black);

        return RGBA::from(
            Red::of((int) \round($red * 255))->unwrap(),
            Green::of((int) \round($green * 255))->unwrap(),
            Blue::of((int) \round($blue * 255))->unwrap(),
            $this->alpha,
        );
    }

    public function toHSLA(): HSLA
    {
        return $this->toRGBA()->toHSLA();
    }

    public function toCMYKA(): self
    {
        return $this;
    }

    public function toString(): string
    {
        if ($this->alpha->atMaximum()) {
            return \sprintf(
                'device-cmyk(%s%%, %s%%, %s%%, %s%%)',
                $this->cyan->toString(),
                $this->magenta->toString(),
                $this->yellow->toString(),
                $this->black->toString(),
            );
        }

        return \sprintf(
            'device-cmyk(%s%%, %s%%, %s%%, %s%%, %s)',
            $this->cyan->toString(),
            $this->magenta->toString(),
            $this->yellow->toString(),
            $this->black->toString(),
            $this->alpha->toFloat(),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function withAlpha(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::PATTERN_WITH_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $cyan = $matches
            ->get('cyan')
            ->filter(static fn($cyan) => \is_numeric($cyan))
            ->map(static fn($cyan) => (int) $cyan)
            ->flatMap(static fn($cyan) => Cyan::of($cyan)->maybe());
        $magenta = $matches
            ->get('magenta')
            ->filter(static fn($magenta) => \is_numeric($magenta))
            ->map(static fn($magenta) => (int) $magenta)
            ->flatMap(static fn($magenta) => Magenta::of($magenta)->maybe());
        $yellow = $matches
            ->get('yellow')
            ->filter(static fn($yellow) => \is_numeric($yellow))
            ->map(static fn($yellow) => (int) $yellow)
            ->flatMap(static fn($yellow) => Yellow::of($yellow)->maybe());
        $black = $matches
            ->get('black')
            ->filter(static fn($black) => \is_numeric($black))
            ->map(static fn($black) => (int) $black)
            ->flatMap(static fn($black) => Black::of($black)->maybe());
        $alpha = $matches
            ->get('alpha')
            ->filter(static fn($alpha) => \is_numeric($alpha))
            ->map(static fn($alpha) => (float) $alpha)
            ->flatMap(static fn($alpha) => Alpha::of($alpha)->maybe());

        return Maybe::all($cyan, $magenta, $yellow, $black, $alpha)
            ->map(self::from(...))
            ->attempt(static fn() => new \DomainException($colour->toString()));
    }

    /**
     * @psalm-pure
     *
     * @return Attempt<self>
     */
    private static function withoutAlpha(Str $colour): Attempt
    {
        $matches = $colour
            ->capture(self::PATTERN_WITHOUT_ALPHA)
            ->map(static fn($_, $match) => $match->toString());
        $cyan = $matches
            ->get('cyan')
            ->filter(static fn($cyan) => \is_numeric($cyan))
            ->map(static fn($cyan) => (int) $cyan)
            ->flatMap(static fn($cyan) => Cyan::of($cyan)->maybe());
        $magenta = $matches
            ->get('magenta')
            ->filter(static fn($magenta) => \is_numeric($magenta))
            ->map(static fn($magenta) => (int) $magenta)
            ->flatMap(static fn($magenta) => Magenta::of($magenta)->maybe());
        $yellow = $matches
            ->get('yellow')
            ->filter(static fn($yellow) => \is_numeric($yellow))
            ->map(static fn($yellow) => (int) $yellow)
            ->flatMap(static fn($yellow) => Yellow::of($yellow)->maybe());
        $black = $matches
            ->get('black')
            ->filter(static fn($black) => \is_numeric($black))
            ->map(static fn($black) => (int) $black)
            ->flatMap(static fn($black) => Black::of($black)->maybe());

        return Maybe::all($cyan, $magenta, $yellow, $black)
            ->map(self::from(...))
            ->attempt(static fn() => new \DomainException($colour->toString()));
    }
}
