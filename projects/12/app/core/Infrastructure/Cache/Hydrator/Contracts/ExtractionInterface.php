<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Hydrator\Contracts;

interface ExtractionInterface
{
    public function extract(object | array $object): array;
}
