<?php

declare(strict_types=1);

namespace App\Domain\Entity\Card\VO;

use App\Exceptions\Assert\Assert;

/**
 * Номер банковской карты.
 */
final class Number implements \Stringable
{
    public const LENGTH = 16;
    /** @var string 16 символов, только числа. */
    public const PATTERN = '#^(\d{16})$#';

    /** @var non-empty-string */
    private readonly string $value;

    /** @param non-empty-string $value*/
    public function __construct(string $value)
    {
        Assert::equals(self::LENGTH, $value);
        Assert::mach(self::PATTERN, $value);

        $this->value = $value;
    }

    /** @return non-empty-string */
    public function getValue(): string
    {
        return $this->value;
    }

    /** @return non-empty-string */
    public function __toString(): string
    {
        return $this->value;
    }
}
