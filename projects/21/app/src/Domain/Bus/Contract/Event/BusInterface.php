<?php

declare(strict_types=1);

namespace App\Domain\Bus\Contract\Event;

interface BusInterface
{
    public function dispatch(EventInterface $event): void;
}
