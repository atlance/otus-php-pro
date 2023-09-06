<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Cache\Repository;

use App\Core\Domain\Entity\Contracts\IdentityInterface;
use App\Core\Infrastructure\Cache\Hydrator\Contracts\ObjectHydratorInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @template T of IdentityInterface
 */
abstract class AbstractRepository
{
    private const IDS_KEY = 'ids';

    public function __construct(
        protected readonly CacheInterface $cache,
        protected readonly ObjectHydratorInterface $hydrator,
        /** @psalm-param class-string<T> $targetClass */
        protected readonly string $targetClass
    ) {
    }

    /**
     * @psalm-param T $object
     *
     * @return T
     *
     * @throws InvalidArgumentException
     */
    public function save(IdentityInterface $object)
    {
        $this->cache->set("{$object->getId()}", $this->hydrator->extract($object));
        $this->toIds("{$object->getId()}");

        return $object;
    }

    /** @throws InvalidArgumentException */
    public function rows(): iterable
    {
        return $this->cache->getMultiple($this->ids());
    }

    public function clear(): bool
    {
        return $this->cache->clear();
    }

    /**
     * @psalm-suppress ArgumentTypeCoercion
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     *
     * @return T
     */
    public function hydrate(array $row): object
    {
        return $this->hydrator->hydrate($row, $this->targetClass);
    }

    /**
     * @psalm-suppress MixedReturnTypeCoercion
     *
     * @return array<array-key,string>
     *
     * @throws InvalidArgumentException
     */
    private function ids(): array
    {
        return (array) $this->cache->get(self::IDS_KEY);
    }

    private function toIds(string $id): bool
    {
        return $this->cache->set(self::IDS_KEY, array_unique(array_merge($this->ids(), [$id])));
    }
}
