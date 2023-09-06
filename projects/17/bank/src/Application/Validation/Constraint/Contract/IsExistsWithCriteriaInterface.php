<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint\Contract;

interface IsExistsWithCriteriaInterface
{
    public function isExists(string $table, array $criteria): bool;
}
