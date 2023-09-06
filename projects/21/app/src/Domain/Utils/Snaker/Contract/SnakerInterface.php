<?php

declare(strict_types=1);

namespace App\Domain\Utils\Snaker\Contract;

interface SnakerInterface
{
    public static function snake(string $value): string;
}
