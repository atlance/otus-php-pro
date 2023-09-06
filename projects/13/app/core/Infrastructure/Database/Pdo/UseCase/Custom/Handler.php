<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Pdo\UseCase\Custom;

use App\Core\Infrastructure\Database\Pdo\Factory\Connection;

final class Handler
{
    private \PDOStatement $statement;

    public function __construct(string $query)
    {
        $this->statement = Connection::getInstance()->prepare($query);
    }

    public function handle(int $mode = \PDO::FETCH_ASSOC, ?array $params = null, bool $list = false)
    {
        $this->statement->execute($params);

        return false === $list ? $this->statement->fetch($mode) : $this->statement->fetchAll($mode);
    }
}
