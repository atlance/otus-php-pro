<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\FindOne\Relevant;

use App\EventStorage\Domain\Entity\Event\Event;
use App\EventStorage\Infrastructure\Cache\Repository\Event\EventRepository;

final class Handler
{
    public function __construct(private readonly EventRepository $repository)
    {
    }

    public function handle(Command $command): ?Event
    {
        return $this->repository->findOneRelevant($command->conditions);
    }
}
