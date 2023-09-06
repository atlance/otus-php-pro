<?php

declare(strict_types=1);

namespace App\Exceptions\Assert\Is;

use App\Exceptions\UnexpectedValueException;

class IsString
{
    public static function assert(mixed $value, ?string $message = null): void
    {
        if (!\is_string($value)) {
            $message ??= sprintf('Unexpected value: %s. Expected a string type', "{$value}");
            throw new UnexpectedValueException($message);
        }
    }
}
