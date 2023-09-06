<?php

declare(strict_types=1);

namespace App\EventStorage\Infrastructure\Database\Pdo\Event\Condition;

use App\Core\Infrastructure\Database\Pdo\AbstractDataMapper;
use App\Core\Infrastructure\Database\Pdo\UseCase;
use App\EventStorage\Domain\Entity\Event\Condition;
use Symfony\Component\Uid\UuidV4;

/**
 * @extends AbstractDataMapper<Condition,array{id:string,event_id:string,name:string,value:int}>
 *
 * @method Condition      get(string $id);
 * @method Condition|null find(string $id);
 * @method string         create(Condition $object);
 * @method bool           update(Condition $object);
 * @method bool           delete(Condition $object);
 */
final class DataMapper extends AbstractDataMapper
{
    public const TABLE = 'events_conditions';
    public const COLUMNS = ['id', 'event_id', 'name', 'value'];

    private UseCase\Custom\Handler $byEventFinder;

    public function __construct()
    {
        parent::__construct(self::TABLE, self::COLUMNS);

        $this->byEventFinder = new UseCase\Custom\Handler(
            sprintf(
                'SELECT %s FROM %s WHERE event_id = :event_id',
                implode(', ', self::COLUMNS),
                self::TABLE
            )
        );
    }

    /** @return array<array-key, Condition> */
    public function findByEventId(string $id): array
    {
        return array_map(
            function (array $row) {
                /** @var array{id:string,event_id:string,name:string,value:int} $row */
                $object = $this->hydrate($row);
                $this->cache->set($object->getId(), $object);

                return $object;
            },
            (array) $this->byEventFinder->handle(params: ['event_id' => $id], list: true)
        );
    }

    /**
     * @param Condition $object
     *
     * @return array{id:string,event_id:string,name:string,value:int}
     */
    public function extract($object): array
    {
        return [
            'id' => $object->getId(),
            'event_id' => $object->getEventId(),
            'name' => $object->getName(),
            'value' => $object->getValue(),
        ];
    }

    /**
     * @param array{id:string,event_id:string,name:string,value:int} $row
     */
    public function hydrate(array $row): Condition
    {
        return new Condition(new UuidV4($row['id']), new UuidV4($row['event_id']), $row['name'], $row['value']);
    }
}
