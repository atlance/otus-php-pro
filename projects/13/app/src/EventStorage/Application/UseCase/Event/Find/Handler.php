<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\Find;

use App\EventStorage\Domain\Entity\Event\Event;
use App\EventStorage\Infrastructure\Database\Pdo\Event\DataMapper;

final class Handler
{
    public function __construct(private readonly DataMapper $storage)
    {
    }

    public function handle(string $id): ?Event
    {
        return $this->storage->find($id);
    }
}
