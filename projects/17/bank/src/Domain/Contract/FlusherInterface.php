<?php

declare(strict_types=1);

namespace App\Domain\Contract;

interface FlusherInterface
{
    public function flush(bool $deferred = false): void;
}
