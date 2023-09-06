<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo\UseCase\Delete;

use App\Core\Infrastructure\Database\Pdo\Factory\Connection;

final class Handler
{
    private const FORMAT = 'DELETE FROM %s WHERE id = :id';

    private \PDOStatement $statement;

    public function __construct(string $table)
    {
        $this->statement = Connection::getInstance()->prepare(sprintf(self::FORMAT, $table));
    }

    public function handle($id): bool
    {
        return $this->statement->execute(['id' => $id]);
    }
}
