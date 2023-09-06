<?php

declare(strict_types=1);

namespace App\Domain\Event\UseCase\Bank\Statement;

use App\Domain\Bus\Contract\Event\EventInterface;
use App\Domain\DataTransferObject;

final class Created extends DataTransferObject implements EventInterface
{
    public string $id;
    public string $email;
    public string $startAt;
    public string $endAt;
}
