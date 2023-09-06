<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\Create;

use App\EventStorage\Domain\Entity\Event\Event;
use App\EventStorage\Infrastructure\Cache\Repository\Event\EventRepository;
use Symfony\Component\Uid\Uuid;

final class Handler
{
    public function __construct(private readonly EventRepository $repository)
    {
    }

    public function handle(Command $command): Event
    {
        return $this->repository->save(new Event(Uuid::v4(), $command->conditions, $command->priority));
    }
}
