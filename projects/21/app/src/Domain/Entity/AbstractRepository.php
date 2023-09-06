<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Exceptions\EntityNotFoundException;
use App\Exceptions\NotExistClassException;
use App\Exceptions\UnexpectedClassException;
use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Connection\ConnectionLoader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;

/**
 * @psalm-template T of object
 */
abstract class AbstractRepository implements ConnectionLoader
{
    protected EntityManagerInterface $em;
    protected ObjectRepository $repository;
    /** @psalm-var class-string */
    private string $targetClass;

    /**
     * @psalm-param class-string<T> $targetClass
     */
    public function __construct(EntityManagerInterface $em, string $targetClass)
    {
        if (false === class_exists($targetClass)) {
            throw new NotExistClassException($targetClass);
        }

        $this->em = $em;
        $this->targetClass = $targetClass;

        $this->repository = $em->getRepository($targetClass);
    }

    /**
     * @psalm-param T $object
     */
    final public function add(object $object): void
    {
        if (!$object instanceof $this->targetClass) {
            throw new UnexpectedClassException($this->targetClass, \get_class($object));
        }
        $this->em->persist($object);
    }

    /**
     * @psalm-return T
     *
     * @throws EntityNotFoundException
     */
    public function get(mixed $id)
    {
        /** @var T $object */
        $object = $this->repository->find($id);
        if ($object instanceof $this->targetClass) {
            $this->em->initializeObject($object);

            return $object;
        }

        throw new EntityNotFoundException("{$this->targetClass} by id: {$id} - not found");
    }

    /**
     * @psalm-return T|null
     */
    final public function find(mixed $id)
    {
        /** @var T|null $object */
        $object = $this->repository->find($id);
        if ($object instanceof $this->targetClass) {
            return $object;
        }

        return null;
    }

    /**
     * @psalm-param T $object
     */
    final public function remove(object $object): void
    {
        if (!$object instanceof $this->targetClass) {
            throw new UnexpectedClassException($this->targetClass, \get_class($object));
        }

        $this->em->remove($object);
    }

    /**
     * @psalm-param T $object
     */
    final public function refresh(object $object): void
    {
        $this->em->refresh($object);
    }

    /**
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedArgument
     * @psalm-suppress MixedArgumentTypeCoercion
     *
     * @psalm-return T[]
     */
    final public function findBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        //phpcs:disable
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
        //phpcs:enable
    }

    /**
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedArgument
     * @psalm-suppress MixedArgumentTypeCoercion
     *
     * @psalm-return T|null
     */
    final public function findOneBy(array $criteria)
    {
        /** @var T|null $object */
        $object = $this->repository->findOneBy($criteria);

        return (\is_object($object) && $object instanceof $this->targetClass) ? $object : null;
    }

    /**
     * @psalm-suppress MixedAssignment
     *
     * @psalm-return T[]
     */
    final public function findByIds(array $ids): array
    {
        if ([] === $ids) {
            return [];
        }

        $expr = $this->em->getExpressionBuilder();
        $qb = $this->em->createQueryBuilder();
        $qb->select('t1')
            ->from($this->targetClass, 't1')
            ->where($expr->in('t1.id', $ids))
        ;

        /** @var null|T[] $result */
        $result = $qb->getQuery()->getResult();

        return \is_array($result) ? $result : [];
    }

    final public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    final public function createQueryBuilder(): QueryBuilder
    {
        return $this->em->createQueryBuilder();
    }

    final public function getConnection(?string $name = null): Connection
    {
        return $this->em->getConnection();
    }
}
