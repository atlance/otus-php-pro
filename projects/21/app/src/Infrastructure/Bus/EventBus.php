<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus;

use App\Domain\Bus\Contract\Event\BusInterface;
use App\Domain\Bus\Contract\Event\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class EventBus implements BusInterface
{
    public function __construct(private readonly MessageBusInterface $eventBus)
    {
    }

    public function dispatch(EventInterface $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
