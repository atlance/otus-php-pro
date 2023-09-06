<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo\UseCase\Find;

use App\Core\Infrastructure\Database\Pdo\Factory\Connection;

/**
 * @psalm-suppress MixedArgumentTypeCoercion
 */
final class Handler
{
    private const FORMAT = 'SELECT %s FROM %s WHERE id = :id';

    private \PDOStatement $statement;

    /**
     * @param <array-key,string> $columns
     */
    public function __construct(string $table, array $columns)
    {
        $this->statement = Connection::getInstance()
            ->prepare(sprintf(self::FORMAT, implode(', ', $columns), $table));
    }

    public function handle(array $params, int $mode = \PDO::FETCH_ASSOC)
    {
        $this->statement->setFetchMode($mode);
        $this->statement->execute($params);

        return $this->statement->fetch();
    }
}
