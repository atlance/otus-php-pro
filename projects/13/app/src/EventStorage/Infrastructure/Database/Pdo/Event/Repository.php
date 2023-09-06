<?php

declare(strict_types=1);

namespace App\EventStorage\Infrastructure\Database\Pdo\Event;

use App\EventStorage\Domain\Entity\Event\Event;

final class Repository
{
    public function __construct(
        private readonly DataMapper $eventDataMapper,
        private readonly Condition\DataMapper $eventConditionDataMapper,
    ) {
    }

    public function find(string $id): ?Event
    {
        return $this->eventDataMapper->find($id);
    }

    public function create(Event $event): void
    {
        $this->eventDataMapper->create($event);
        foreach ($event->getConditions() as $condition) {
            $this->eventConditionDataMapper->create($condition);
        }
    }

    public function update(Event $event): void
    {
        $this->eventDataMapper->update($event);
        $conditions = $this->eventConditionDataMapper->findByEventId($event->getId());
        foreach ($conditions as $condition) {
            $this->eventConditionDataMapper->delete($condition);
        }

        foreach ($event->getConditions() as $condition) {
            $this->eventConditionDataMapper->create($condition);
        }
    }
}
