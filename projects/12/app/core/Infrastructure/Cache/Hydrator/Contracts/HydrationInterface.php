<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Hydrator\Contracts;

interface HydrationInterface
{
    /**
     * @param class-string $className
     *
     * @return mixed
     */
    public function hydrate(mixed $data, string $className);
}
