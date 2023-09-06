<?php

declare(strict_types=1);

namespace App\Domain\Query\UseCase\Bank\Statement\View;

use App\Domain\DataTransferObject;
use App\Domain\Entity\Bank\Status;
use OpenApi\Attributes as OA;

final class Statement extends DataTransferObject
{
    #[OA\Property(description: 'Идентификатор', type: 'string')]
    public string $id;

    #[OA\Property(description: 'Адрес электронной почты', type: 'string')]
    public string $email;

    #[OA\Property(description: 'Статус выписки', type: 'string')]
    public string $status;

    public function setStatus(int $status): void
    {
        $this->status = Status::from($status)->alias();
    }
}
