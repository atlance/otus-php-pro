<?php

declare(strict_types=1);

namespace App\Domain\Event\UseCase\Bank\Statement\Created\Subscriber\Generate\Contract;

interface GeneratorInterface
{
    public function generate(string $id, ?int $timeout): void;
}
