<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus;

use App\Domain\Bus\Contract\Query\BusInterface;
use App\Domain\Bus\Contract\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class QueryBus implements BusInterface
{
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
    }

    public function dispatch(QueryInterface $query): mixed
    {
        return $this->queryBus->dispatch($query)->last(HandledStamp::class)?->getResult();
    }
}
