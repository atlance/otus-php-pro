<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\Storage\Clear;

use App\EventStorage\Infrastructure\Cache\Repository\Event\EventRepository;

final class Handler
{
    public function __construct(private readonly EventRepository $repository)
    {
    }

    public function handle(): bool
    {
        return $this->repository->clear();
    }
}
