<?php

declare(strict_types=1);

namespace App\Exceptions\Assert\Regexp;

use App\Exceptions\UnexpectedValueException;

class Mach
{
    public static function assert(string $pattern, string $value, ?string $message = null): void
    {
        if (!preg_match($pattern, $value)) {
            // phpcs:disable
            throw new UnexpectedValueException($message ?? sprintf('The value %s does not match the expected pattern.', $pattern));
            // phpcs:enable
        }
    }
}
