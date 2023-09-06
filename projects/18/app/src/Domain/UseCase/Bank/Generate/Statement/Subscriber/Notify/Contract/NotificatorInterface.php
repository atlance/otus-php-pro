<?php

declare(strict_types=1);

namespace App\Domain\UseCase\Bank\Generate\Statement\Subscriber\Notify\Contract;

use App\Domain\UseCase\Bank\Generate\Statement\Event;

interface NotificatorInterface
{
    public function notify(Event\Created $event): void;
}
