<?php

declare(strict_types=1);

namespace App\Domain\Utils\Snaker;

use Symfony\Component\String\UnicodeString;

final class Snaker implements Contract\SnakerInterface
{
    public static function snake(string $value): string
    {
        return (new UnicodeString($value))->snake()->toString();
    }
}
