<?php

declare(strict_types=1);

namespace App\Domain\Query\UseCase\Bank\Statement\View;

use App\Domain\Entity\Bank\Statement;
use App\Domain\Query\AbstractFetcher;
use Doctrine\DBAL\Exception;
use Symfony\Component\Uid\UuidV7;

final class Fetcher extends AbstractFetcher
{
    /**
     * @return false|array<string,mixed>
     *
     * @throws Exception
     */
    public function fetch(UuidV7 $id): false | array
    {
        $qb = $this->createQueryBuilder();
        $expr = $this->createExpressionBuilder();

        return $qb
            ->select(['t.id', 't.email', 't.status'])
            ->from(Statement::TABLE_NAME, 't')
            ->where($expr->eq('t.id', ':id'))
            ->setParameter('id', $id->toRfc4122())
            ->executeQuery()
            ->fetchAssociative()
        ;
    }
}
