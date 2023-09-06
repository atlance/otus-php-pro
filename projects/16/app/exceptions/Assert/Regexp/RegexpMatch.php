<?php

declare(strict_types=1);

namespace App\Exceptions\Assert\Regexp;

use App\Exceptions\UnexpectedValueException;

class RegexpMatch
{
    public static function assert(string $pattern, string $value, ?string $message = null): void
    {
        if (false === preg_match($pattern, $value)) {
            $message ??= sprintf('The value %s does not match the expected pattern.', $pattern);
            throw new UnexpectedValueException($message);
        }
    }
}
