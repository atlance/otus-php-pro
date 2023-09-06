<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Cache;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

final class Cleaner
{
    public static function clear(KernelInterface $kernel): void
    {
        (new Filesystem())->remove($kernel->getCacheDir());
    }
}
