<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Adapter;

use Symfony\Component\Cache\Adapter\AbstractAdapter;

interface FactoryInterface
{
    public function create(string $namespace): AbstractAdapter;

    public static function getAdapterKey(): string;
}
