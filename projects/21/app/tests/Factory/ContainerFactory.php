<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Kernel;
use App\Tests\Infrastructure\Cache;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ContainerFactory
{
    public static function create(string $environment, bool $debug, bool $clearCache = false): ContainerInterface
    {
        $kernel = new Kernel($environment, $debug);

        if ($clearCache) {
            Cache\Cleaner::clear($kernel);
        }

        $kernel->boot();

        return $kernel->getContainer();
    }
}
