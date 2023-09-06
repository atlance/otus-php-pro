<?php

declare(strict_types=1);

namespace App\Domain\Bus\Contract\Command;

interface BusInterface
{
    public function dispatch(CommandInterface $command): void;
}
