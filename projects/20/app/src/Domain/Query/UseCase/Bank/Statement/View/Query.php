<?php

declare(strict_types=1);

namespace App\Domain\Query\UseCase\Bank\Statement\View;

use App\Domain\Bus\Contract\Query\QueryInterface;
use App\Domain\DataTransferObject;
use Symfony\Component\Uid\UuidV7;

final class Query extends DataTransferObject implements QueryInterface
{
    public UuidV7 $id;
}
