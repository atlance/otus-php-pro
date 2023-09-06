<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal;

use App\Application\Validation\Constraint\Contract\IsExistsWithCriteriaInterface;
use Doctrine\DBAL\Connection;

final class CriteriaChecker implements IsExistsWithCriteriaInterface
{
    public function __construct(protected Connection $connection)
    {
    }

    public function isExists(string $table, array $criteria): bool
    {
        $qb = $this->connection->createQueryBuilder();
        $expr = $qb->expr();

        $qb->select('t.id')->from($table, 't');

        foreach ($criteria as $column => $value) {
            $qb
                ->andWhere($expr->eq("t.{$column}", ":{$column}"))
                ->setParameter($column, $value);
        }

        return $this->connection->createQueryBuilder()
            ->select(sprintf('EXISTS(%s)', SQLPreparer::prepare($this->connection, $qb)))
            ->executeQuery()
            ->fetchOne();
    }
}
