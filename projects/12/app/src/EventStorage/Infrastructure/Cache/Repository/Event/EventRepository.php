<?php

declare(strict_types=1);

namespace App\EventStorage\Infrastructure\Cache\Repository\Event;

use App\Core\Infrastructure\Cache\Adapter\FactoryInterface;
use App\Core\Infrastructure\Cache\Hydrator\Contracts\ObjectHydratorInterface;
use App\Core\Infrastructure\Cache\Repository\AbstractRepository;
use App\Core\Infrastructure\Cache\SimpleCache\SimpleCacheBridge as Cache;
use App\EventStorage\Domain\Entity\Event\Event;

/**
 * @extends AbstractRepository<Event>
 *
 * @method Event save(object $object);
 * @method Event hydrate(array $row);
 */
final class EventRepository extends AbstractRepository
{
    public function __construct(FactoryInterface $factory, ObjectHydratorInterface $hydrator)
    {
        parent::__construct(new Cache($factory->create(Event::TABLE)), $hydrator, Event::class);
    }

    public function findOneRelevant(array $conditions): ?Event
    {
        $event = null;
        $maxPriority = \PHP_INT_MIN;

        /** @var array{id:string, priority:int, conditions:array} $row */
        foreach ($this->rows() as $row) {
            if ($maxPriority < $row['priority'] && 0 === \count(array_diff_assoc($row['conditions'], $conditions))) {
                $maxPriority = $row['priority'];
                $event = $row;
            }
        }

        return null !== $event ? $this->hydrate($event) : null;
    }
}
