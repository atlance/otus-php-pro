<?php

declare(strict_types=1);

namespace App\Exceptions\Assert;

final class Assert
{
    public static function min(int $length, string $value, ?string $message = null): void
    {
        Length\Min::assert($length, $value, $message);
    }

    public static function max(int $length, string $value, ?string $message = null): void
    {
        Length\Max::assert($length, $value, $message);
    }

    public static function equals(int $length, string $value, ?string $message = null): void
    {
        Length\Equals::assert($length, $value, $message);
    }

    public static function mach(string $pattern, string $value, ?string $message = null): void
    {
        Regexp\Mach::assert($pattern, $value, $message);
    }

    public static function numeric(mixed $value, ?string $message = null): void
    {
        Is\Numeric::assert($value, $message);
    }

    public static function string(mixed $value, ?string $message = null): void
    {
        Is\IsString::assert($value, $message);
    }
}
