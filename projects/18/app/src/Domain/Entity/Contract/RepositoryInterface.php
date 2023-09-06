<?php

declare(strict_types=1);

namespace App\Domain\Entity\Contract;

interface RepositoryInterface
{
    public function findOneBy(array $criteria): ?object;
}
