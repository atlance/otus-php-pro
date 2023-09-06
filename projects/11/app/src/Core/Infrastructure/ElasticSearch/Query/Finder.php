<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\ElasticSearch\Query;

use App\Core\Domain\Contracts\EntityInterface;
use App\Core\Exceptions\UnexpectedClassException;
use Elastica\Query\AbstractQuery;
use JoliCode\Elastically\Client as Connection;

/**
 * @template T of EntityInterface
 */
final class Finder
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @psalm-suppress InvalidArgument - В пакете неверная декларация, поэтому InvalidArgument тушим.
     *
     * @param class-string<T> $entityClass
     *
     * @return array<int, T>
     */
    public function find(string $entityClass, AbstractQuery $criteria): array
    {
        $resultSet = $this->connection->getIndex($entityClass::tableName())->createSearch($criteria)->search();
        $objects = [];

        foreach ($resultSet->getResults() as $result) {
            if (!method_exists($result, 'getModel')) {
                continue;
            }

            $object = $result->getModel();

            if (!$object instanceof $entityClass) {
                throw new UnexpectedClassException($entityClass);
            }

            $objects[] = $object;
        }

        return $objects;
    }
}
