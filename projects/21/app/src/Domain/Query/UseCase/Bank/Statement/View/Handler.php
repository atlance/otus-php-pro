<?php

declare(strict_types=1);

namespace App\Domain\Query\UseCase\Bank\Statement\View;

use App\Domain\Bus\Contract\Query\HandlerInterface;

final class Handler implements HandlerInterface
{
    public function __construct(private readonly Fetcher $fetcher)
    {
    }

    public function handle(Query $query): ?Statement
    {
        $row = $this->fetcher->fetch($query->id);
        if (false === $row) {
            return null;
        }

        return Statement::fromArray($row);
    }
}
