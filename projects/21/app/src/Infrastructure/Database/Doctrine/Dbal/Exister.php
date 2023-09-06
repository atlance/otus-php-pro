<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal;

use App\Domain\Entity\Contract\IsExistInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

final class Exister implements IsExistInterface
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function isExistByCriteria(string $tableName, array $criteria): bool
    {
        $qb = $this->createQueryBuilder();
        $expr = $qb->expr();

        $qb->select('t.id')->from($tableName, 't');

        foreach ($criteria as $column => $value) {
            $qb
                ->andWhere($expr->eq("t.{$column}", ":{$column}"))
                ->setParameter($column, $value);
        }

        return $this->createQueryBuilder()
            ->select(sprintf('EXISTS(%s)', SQLPreparer::prepare($this->connection, $qb)))
            ->executeQuery()
            ->fetchOne();
    }

    public function isExistColumn(string $tableName, string ...$column): bool
    {
        return [] === array_diff($column, $this->tableColumns($tableName));
    }

    public function isExistTable(string $tableName): bool
    {
        return \is_string(
            $this->createQueryBuilder()
                ->select("to_regclass('public.{$tableName}')")
                ->executeQuery()
                ->fetchOne()
        );
    }

    private function tableColumns(string $tableName): array
    {
        return array_keys($this->connection->createSchemaManager()->listTableColumns($tableName));
    }

    private function createQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }
}
