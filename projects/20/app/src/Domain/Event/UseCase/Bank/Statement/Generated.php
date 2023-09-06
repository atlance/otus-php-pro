<?php

declare(strict_types=1);

namespace App\Domain\Event\UseCase\Bank\Statement;

use App\Domain\Bus\Contract\Event\EventInterface;
use App\Domain\DataTransferObject;
use App\Domain\Entity\Bank\Status;
use App\Domain\Entity\VO\Email;
use DateTime;

final class Generated extends DataTransferObject implements EventInterface
{
    public string $id;
    public Email $email;
    public DateTime $startAt;
    public DateTime $endAt;
    public Status $status;
}
