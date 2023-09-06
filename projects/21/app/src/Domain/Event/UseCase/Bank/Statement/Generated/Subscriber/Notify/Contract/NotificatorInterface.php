<?php

declare(strict_types=1);

namespace App\Domain\Event\UseCase\Bank\Statement\Generated\Subscriber\Notify\Contract;

use App\Domain\Event\UseCase\Bank\Statement\Generated;

interface NotificatorInterface
{
    public function notify(Generated $event): void;
}
