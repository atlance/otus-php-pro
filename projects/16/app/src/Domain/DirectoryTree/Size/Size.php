<?php

declare(strict_types=1);

namespace App\Domain\DirectoryTree\Size;

use App\Exceptions\Assert\Assert;

final class Size implements \Stringable
{
    public const PATTERN = '#^\d+ (B|KB|MB|GB|TB)$#';

    public function __construct(private int $value = 0, private Unit $unit = Unit::B)
    {
    }

    public function byte(): int
    {
        return $this->value * $this->unit->value;
    }

    public function add(self $other): void
    {
        $this->value = $this->byte() + $other->byte();
        $this->unit = Unit::B;
    }

    public static function fromString(string $value): self
    {
        $value = mb_strtoupper($value);
        Assert::match(self::PATTERN, $value);
        [$value, $unit] = explode(' ', $value);

        return new self((int) $value, Unit::fromName($unit));
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->value, $this->unit->name);
    }
}
