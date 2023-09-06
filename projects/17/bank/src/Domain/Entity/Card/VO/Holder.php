<?php

declare(strict_types=1);

namespace App\Domain\Entity\Card\VO;

use App\Exceptions\Assert\Assert;

/**
 * Имя(и фамилия) держателя карты.
 */
final class Holder implements \Stringable
{
    public const MAX_LENGTH = 255;
    public const MIN_LENGTH = 3;
    /** @var string 1 или 2 слова разделённых пробелом, латинскими буквами, суммарной длинной не более 255 символов. */
    public const PATTERN = '#^[a-zA-Z]{1,127}(?: [a-zA-Z]{1,127})$#';

    /** @var non-empty-string */
    private readonly string $value;

    /** @param non-empty-string $value*/
    public function __construct(string $value)
    {
        Assert::min(self::MIN_LENGTH, $value);
        Assert::max(self::MAX_LENGTH, $value);
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
