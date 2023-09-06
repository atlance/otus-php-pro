<?php

declare(strict_types=1);

namespace App\Exceptions\Assert\Is;

use App\Exceptions\UnexpectedValueException;

class Numeric
{
    public static function assert(mixed $value, ?string $message = null): void
    {
        if (!is_numeric($value)) {
            $message ??= sprintf('Unexpected value: %s. Expected a numeric', "{$value}");
            throw new UnexpectedValueException($message);
        }
    }
}
