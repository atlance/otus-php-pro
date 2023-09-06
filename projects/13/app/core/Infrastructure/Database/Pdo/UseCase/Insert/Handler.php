<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo\UseCase\Insert;

use App\Core\Infrastructure\Database\Pdo\Factory\Connection;

final class Handler
{
    private const FORMAT = 'INSERT INTO %s (%s) VALUES (%s) RETURNING id';

    private \PDOStatement $statement;

    public function __construct(string $table, array $columns)
    {
        $this->statement = Connection::getInstance()->prepare(
            sprintf(
                self::FORMAT,
                $table,
                implode(', ', $columns),
                implode(', ', array_map(static fn (string $column) => ":{$column}", $columns))
            )
        );
    }

    /**
     * @param array<string, scalar> $params
     */
    public function handle(array $params): int | string
    {
        $this->statement->execute($params);

        return $this->statement->fetchColumn();
    }
}
