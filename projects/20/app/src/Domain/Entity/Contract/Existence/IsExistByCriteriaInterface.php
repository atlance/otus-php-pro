<?php

declare(strict_types=1);

namespace App\Domain\Entity\Contract\Existence;

interface IsExistByCriteriaInterface
{
    public function isExistByCriteria(string $tableName, array $criteria): bool;
}
