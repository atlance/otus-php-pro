<?php

declare(strict_types=1);

namespace App\Domain\UseCase\Bank\Generate\Statement\Event;

use App\Domain\Bus\Contract\Event\EventInterface;
use App\Domain\DataTransferObject;

class Created extends DataTransferObject implements EventInterface
{
    public string $id;
    public string $email;
    public string $startDate;
    public string $endDate;
}
