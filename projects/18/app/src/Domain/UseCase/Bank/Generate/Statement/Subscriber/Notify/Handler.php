<?php

declare(strict_types=1);

namespace App\Domain\UseCase\Bank\Generate\Statement\Subscriber\Notify;

use App\Domain\Bus\Contract\Event\HandlerInterface;
use App\Domain\UseCase\Bank\Generate\Statement\Event;

final class Handler implements HandlerInterface
{
    public function __construct(private readonly Contract\NotificatorInterface $notificator)
    {
    }

    public function handle(Event\Created $event): void
    {
        $this->notificator->notify($event);
    }
}
