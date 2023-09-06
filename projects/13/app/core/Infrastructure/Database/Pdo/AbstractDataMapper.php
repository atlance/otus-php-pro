<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo;

use App\Contracts\IdentityInterface;

/**
 * @psalm-suppress MixedInferredReturnType
 * @psalm-suppress MixedReturnStatement
 *
 * @template T of IdentityInterface
 * @template TH of array
 */
abstract class AbstractDataMapper
{
    protected Factory\IdentityMap $cache;

    private UseCase\Insert\Handler $inserter;
    private UseCase\Find\Handler $finder;
    private UseCase\Delete\Handler $deleter;

    public function __construct(protected string $table, array $columns)
    {
        $this->cache = Factory\IdentityMap::getInstance($table);
        $this->inserter = new UseCase\Insert\Handler($this->table, $columns);
        $this->finder = new UseCase\Find\Handler($this->table, $columns);
        $this->deleter = new UseCase\Delete\Handler($this->table);
    }

    /**
     * @param TH $row
     *
     * @return T
     */
    abstract protected function hydrate(array $row);

    /**
     * @param T $object
     *
     * @return TH
     */
    abstract protected function extract($object);

    /** @psalm-return T */
    public function get(int | string $id): object
    {
        $object = $this->cache->find($id);
        if (null !== $object) {
            return $object;
        }

        $row = $this->finder->handle(['id' => $id]);
        if (!\is_array($row)) {
            throw new \DomainException('not found record');
        }

        $object = $this->hydrate($row);
        $this->cache->set($id, $object);

        return $object;
    }

    /** @psalm-return null|T */
    public function find(int | string $id): ?object
    {
        $object = $this->cache->find($id);
        if (null !== $object) {
            return $object;
        }

        $row = $this->finder->handle(['id' => $id]);
        if (\is_array($row)) {
            $object = $this->hydrate($row);
            $this->cache->set($id, $object);

            return $object;
        }

        return null;
    }

    /**
     * @psalm-param T $object
     *
     * @return string|int - identity
     */
    public function create(object $object): int | string
    {
        $id = $this->inserter->handle($this->extract($object));
        $object = $this->get($id);

        $this->cache->set($id, $object);

        return $id;
    }

    /** @param T $object */
    public function update(object $object): bool
    {
        $id = $object->getId();

        $row = $this->finder->handle(['id' => $id]);
        if (!\is_array($row)) {
            throw new \UnexpectedValueException();
        }

        $diff = array_diff_assoc($this->extract($object), $row);
        if (0 < \count($diff) && (new UseCase\Update\Handler($this->table, array_keys($diff)))->handle($id, $diff)) {
            $this->cache->set($id, $object);

            return true;
        }

        return false;
    }

    /** @param T $object */
    public function delete(object $object): bool
    {
        if ($this->deleter->handle($object->getId())) {
            $this->cache->delete($object->getId());

            return true;
        }

        return false;
    }
}
