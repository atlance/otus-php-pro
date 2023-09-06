<?php

declare(strict_types=1);

namespace App\Domain\Entity\Contract\Existence;

interface IsExistColumnInterface
{
    public function isExistColumn(string $tableName, string ...$column): bool;
}
