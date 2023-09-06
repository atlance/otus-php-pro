<?php

declare(strict_types=1);

namespace App\EventStorage\Infrastructure\Database\Pdo\Event;

use App\Core\Infrastructure\Database\Pdo\AbstractDataMapper;
use App\Core\Infrastructure\Database\Pdo\UseCase;
use App\EventStorage\Domain\Entity\Event\Event;
use Symfony\Component\Uid\UuidV4;

/**
 * @extends AbstractDataMapper<Event,array{id:string,priority:int,name:string}>
 *
 * @method Event      get(string $id);
 * @method Event|null find(string $id);
 * @method string     create(Event $object);
 * @method bool       update(Event $object);
 * @method bool       delete(Event $object);
 */
final class DataMapper extends AbstractDataMapper
{
    public const TABLE = 'events';
    public const COLUMNS = ['id', 'priority', 'name'];

    private UseCase\Custom\Handler $all;

    public function __construct()
    {
        parent::__construct(self::TABLE, self::COLUMNS);

        $this->all = new UseCase\Custom\Handler(
            sprintf('SELECT %s FROM %s', implode(', ', self::COLUMNS), self::TABLE)
        );
    }

    /**
     * @return array<array-key, Event>
     */
    public function all(): array
    {
        return array_map(
            function (array $row) {
                /** @var array{id:string,name:string,priority:int} $row */
                $object = $this->hydrate($row);
                $this->cache->set($object->getId(), $object);

                return $object;
            },
            (array) $this->all->handle(list: true)
        );
    }

    /**
     * @param Event $object
     *
     * @return array{id:string,priority:int,name:string}
     */
    public function extract($object): array
    {
        return [
            'id' => $object->getId(),
            'priority' => $object->getPriority(),
            'name' => $object->getName(),
        ];
    }

    /**
     * @param array{id:string,priority:int,name:string} $row
     */
    public function hydrate(array $row): Event
    {
        return new Event(new UuidV4($row['id']), $row['priority'], $row['name']);
    }
}
