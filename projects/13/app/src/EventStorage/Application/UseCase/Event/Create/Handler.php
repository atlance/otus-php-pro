<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\Create;

use App\EventStorage\Domain\Entity\Event\Condition;
use App\EventStorage\Domain\Entity\Event\Event;
use App\EventStorage\Infrastructure\Database\Pdo\Event\Repository;
use Symfony\Component\Uid\UuidV4;

final class Handler
{
    public function __construct(private readonly Repository $repository)
    {
    }

    public function handle(Command $command): Event
    {
        $event = new Event(new UuidV4(), $command->priority, $command->name);

        $conditions = [];
        foreach ($command->conditions as $name => $value) {
            $conditions[] = new Condition(new UuidV4(), new UuidV4($event->getId()), $name, $value);
        }

        $this->repository->create($event->setConditions($conditions));

        return $event;
    }
}
