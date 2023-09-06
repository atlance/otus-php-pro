<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Contract\RepositoryInterface;

/**
 * @template T of object
 */
abstract class AbstractRepository implements RepositoryInterface
{
    public function __construct(
        /** @psalm-var class-string */
        protected readonly string $targetClass
    ) {
    }

    /**
     * Emulating.
     *
     * @psalm-return T|null
     */
    public function findOneBy(array $criteria): ?object
    {
        return null;
    }
}
