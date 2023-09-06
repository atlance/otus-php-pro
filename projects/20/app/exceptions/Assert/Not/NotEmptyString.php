<?php

declare(strict_types=1);

namespace App\Exceptions\Assert\Not;

use App\Exceptions\Assert\Is\IsString;
use App\Exceptions\UnexpectedValueException;

class NotEmptyString
{
    public static function assert(mixed $value, ?string $message = null): void
    {
        IsString::assert($value);

        if ('' === $value) {
            $message ??= sprintf('Unexpected value: %s. Expected non-empty string value', $value);
            throw new UnexpectedValueException($message);
        }
    }
}
