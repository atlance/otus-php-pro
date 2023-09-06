<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Console\Factory;

final class InputOptionFactory
{
    public static function create(array $hashtable): array
    {
        return array_map(static fn ($key, $value): string => "--${key}={$value}", array_keys($hashtable), $hashtable);
    }
}
