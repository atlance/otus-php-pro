<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo\UseCase\Update;

use App\Core\Infrastructure\Database\Pdo\Factory\Connection;

final class Handler
{
    private const FORMAT = 'UPDATE %s SET %s WHERE id = :id';

    private \PDOStatement $statement;

    /**
     * @param <array-key,string> $columns
     */
    public function __construct(string $table, array $columns)
    {
        $this->statement = Connection::getInstance()->prepare(
            sprintf(
                self::FORMAT,
                $table,
                implode(', ', array_map(static fn ($column) => "{$column} = :{$column}", $columns))
            )
        );
    }

    public function handle(int | string $id, array $params): bool
    {
        return $this->statement->execute(array_merge(['id' => $id], $params));
    }
}
