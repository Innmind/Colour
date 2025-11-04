# Changelog

## [Unreleased]

### Changed

- Requires PHP `8.4`
- Named constructors `::of()`, `::fromHexadecimal()` and `::fromIntensity()` now return instances of `Innmind\Immutable\Attempt`
- `Innmind\Colour\Alpha` constructor is now private, use `::of()` instead
- `Innmind\Colour\Back` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Blue` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Cyan` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Green` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Hue` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Intensity` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Lightness` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Magenta` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Red` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Saturation` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\Yellow` constructor is now private, use `::of()` or `::at()` instead
- `Innmind\Colour\CMYKA` constructor is now private, use `::from()` instead
- `Innmind\Colour\HSLA` constructor is now private, use `::from()` instead
- `Innmind\Colour\RGBA` constructor is now private, use `::from()` instead

### Removed

- `Innmind\Colour\Exception\Exception`
- `Innmind\Colour\Exception\DomainException`
- `Innmind\Colour\Exception\InvalidValueRangeException`

### Fixed

- PHP `8.4` deprecations

## 4.3.0 - 2025-03-20

### Added

- Support for `innmind/black-box` `6`

## 4.2.0 - 2023-09-16

### Added

- Support for `innmind/immutable` `5`
