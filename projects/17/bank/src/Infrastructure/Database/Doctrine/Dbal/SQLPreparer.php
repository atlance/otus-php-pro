<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ExpandArrayParameters;
use Doctrine\DBAL\Query\QueryBuilder;

final class SQLPreparer
{
    public static function prepare(Connection $connection, QueryBuilder $qb): string
    {
        $parser = $connection->getDatabasePlatform()->createSQLParser();
        $visitor = new ExpandArrayParameters($qb->getParameters(), $qb->getParameterTypes());

        $parser->parse($qb->getSQL(), $visitor);
        [$sql, $params, $types] = [
            $visitor->getSQL(),
            $visitor->getParameters(),
            $visitor->getTypes(),
        ];

        $parts = [];
        foreach (explode('?', $sql) as $item) {
            $parts[] = $item;
            $parts[] = '?';
        }
        if (\count($parts) > 1) {
            array_pop($parts);
        }

        if (\count($params) > 0) {
            foreach ($parts as $i => $part) {
                if ('?' === $part) {
                    $firstKeyParam = array_key_first($params);

                    if (\array_key_exists($firstKeyParam, $types)) { /* @phpstan-ignore-line */
                        $parts[$i] = $connection->quote($params[$firstKeyParam], $types[$firstKeyParam]);
                    } else {
                        $parts[$i] = $connection->quote($params[$firstKeyParam]);
                    }

                    unset($params[$firstKeyParam], $types[$firstKeyParam]);
                }
            }
        }

        return implode('', $parts);
    }
}
