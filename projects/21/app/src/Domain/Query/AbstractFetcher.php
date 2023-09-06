<?php

declare(strict_types=1);

namespace App\Domain\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Doctrine\DBAL\Query\QueryBuilder;

abstract class AbstractFetcher
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function createQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }

    public function createExpressionBuilder(): ExpressionBuilder
    {
        return $this->connection->createQueryBuilder()->expr();
    }
}
