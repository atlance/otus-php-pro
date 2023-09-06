<?php

declare(strict_types=1);

namespace App\Domain\Event\UseCase\Bank\Statement\Generated\Subscriber\Notify;

use App\Domain\Bus\Contract\Event\HandlerInterface;
use App\Domain\Event\UseCase\Bank\Statement\Generated;

final class Handler implements HandlerInterface
{
    public function __construct(private readonly Contract\NotificatorInterface $notificator)
    {
    }

    public function handle(Generated $event): void
    {
        $this->notificator->notify($event);
    }
}
