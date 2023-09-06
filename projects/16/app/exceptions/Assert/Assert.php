<?php

declare(strict_types=1);

namespace App\Exceptions\Assert;

final class Assert
{
    public static function match(string $pattern, string $value, ?string $message = null): void
    {
        Regexp\RegexpMatch::assert($pattern, $value, $message);
    }

    public static function dir(string $value, ?string $message = null): void
    {
        FileStorage\Directory::assert($value, $message);
    }
}
