<?php

declare(strict_types=1);

namespace App\Domain\Entity\Order\VO;

use App\Exceptions\Assert\Assert;

class Number implements \Stringable
{
    public const MIN_LENGTH = 1;
    public const MAX_LENGTH = 16;
    /** @var string 1-16 символов, только числа. */
    public const PATTERN = '#^(.{1,16})$#';

    private readonly string $value;

    public function __construct(string $value = null)
    {
        if (null === $value) {
            $this->value = NumberGenerator::generate(self::MIN_LENGTH, self::MAX_LENGTH);

            return;
        }

        Assert::min(self::MIN_LENGTH, $value);
        Assert::max(self::MAX_LENGTH, $value);

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
