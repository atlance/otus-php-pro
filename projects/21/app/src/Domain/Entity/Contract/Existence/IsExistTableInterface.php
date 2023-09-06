<?php

declare(strict_types=1);

namespace App\Domain\Entity\Contract\Existence;

interface IsExistTableInterface
{
    public function isExistTable(string $tableName): bool;
}
