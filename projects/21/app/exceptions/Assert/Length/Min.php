<?php

declare(strict_types=1);

namespace App\Exceptions\Assert\Length;

use App\Exceptions\UnexpectedValueException;

class Min
{
    public static function assert(int $length, string $value, ?string $message = null): void
    {
        if ($length > mb_strlen($value)) {
            throw new UnexpectedValueException($message ?? sprintf('out of min range - %s', $length));
        }
    }
}
