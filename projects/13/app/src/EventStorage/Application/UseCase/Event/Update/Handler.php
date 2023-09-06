<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\Update;

use App\EventStorage\Domain\Entity\Event\Condition;
use App\EventStorage\Domain\Entity\Event\Event;
use App\EventStorage\Infrastructure\Database\Pdo\Event\Repository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\UuidV4;

final class Handler
{
    public function __construct(private readonly Repository $repository)
    {
    }

    public function handle(Command $command): Event
    {
        $event = $this->repository->find($command->id);
        if (null === $event) {
            throw new NotFoundHttpException();
        }

        $conditions = [];
        foreach ($command->conditions as $name => $value) {
            $conditions[] = new Condition(new UuidV4(), new UuidV4($event->getId()), $name, $value);
        }

        $event
            ->setPriority($command->priority)
            ->setName($command->name)
            ->setConditions($conditions);

        $this->repository->update($event);

        return $event;
    }
}
