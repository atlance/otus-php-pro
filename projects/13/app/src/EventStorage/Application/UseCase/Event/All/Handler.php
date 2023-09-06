<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\All;

use App\EventStorage\Domain\Entity\Event\Event;
use App\EventStorage\Infrastructure\Database\Pdo\Event\DataMapper;

final class Handler
{
    public function __construct(private readonly DataMapper $storage)
    {
    }

    /** @return Event[] */
    public function handle(): array
    {
        return $this->storage->all();
    }
}
