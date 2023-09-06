<?php

declare(strict_types=1);

namespace App\Domain\Entity\Contract;

interface FlusherInterface
{
    public function flush(bool $deferred = false): void;
}
