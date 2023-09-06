<?php

declare(strict_types=1);

namespace App\Domain\Bus\Middleware\Contract;

interface LockableInterface
{
    /** Lock key */
    public function getKey(): string;

    /** TTL in seconds */
    public function getTtl(): ?int;
}
