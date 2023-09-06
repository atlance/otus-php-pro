<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Adapter\Memcached;

use App\Core\Infrastructure\Cache\Adapter\FactoryInterface;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;

final class Factory implements FactoryInterface
{
    public const KEY = 'memcached';

    public function __construct(private readonly \Memcached $client)
    {
    }

    public function create(string $namespace): MemcachedAdapter
    {
        return new MemcachedAdapter($this->client, $namespace);
    }

    /** @codeCoverageIgnore */
    public static function getAdapterKey(): string
    {
        return self::KEY;
    }
}
