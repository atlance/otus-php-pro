<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Adapter\Redis;

use App\Core\Infrastructure\Cache\Adapter\FactoryInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final class Factory implements FactoryInterface
{
    public const KEY = 'redis';

    public function __construct(private readonly \Redis $client)
    {
    }

    public function create(string $namespace): RedisAdapter
    {
        return new RedisAdapter($this->client, $namespace);
    }

    /** @codeCoverageIgnore */
    public static function getAdapterKey(): string
    {
        return self::KEY;
    }
}
