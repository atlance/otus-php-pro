<?php

declare(strict_types=1);

namespace App\Exceptions\Assert\FileStorage;

use App\Exceptions\UnexpectedValueException;

class Directory
{
    public static function assert(string $value, ?string $message = null): void
    {
        if (!is_dir($value)) {
            $message ??= sprintf('%s is not a directory.', $value);
            throw new UnexpectedValueException($message);
        }
    }
}
