<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

final class ContainerFactory
{
    public function create(string $environment, bool $debug): ContainerInterface
    {
        $kernel = new Kernel($environment, $debug);
        $this->cacheClear($kernel);

        $kernel->boot();

        return $kernel->getContainer();
    }

    public function cacheClear(KernelInterface $kernel): void
    {
        (new Filesystem())->remove($kernel->getCacheDir());
    }
}
