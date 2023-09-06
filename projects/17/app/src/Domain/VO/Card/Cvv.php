<?php

declare(strict_types=1);

namespace App\Domain\VO\Card;

use App\Exceptions\Assert\Assert;

/**
 * Код CVV, печатается на обратной стороне карты.
 */
final class Cvv implements \Stringable
{
    public const LENGTH = 3;
    /** @var string 3 символа, только числа. */
    public const PATTERN = '#^(\d{3})$#';

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
