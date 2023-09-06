<?php

declare(strict_types=1);

namespace App\Domain\UseCase\Bank\Generate\Statement\Contract;

use App\Domain\UseCase\Bank\Generate\Statement\Command;

interface GeneratorInterface
{
    public function generate(Command $command): void;
}
