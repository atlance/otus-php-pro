<?php

declare(strict_types=1);

namespace App\Domain\Bus\Contract\Query;

interface BusInterface
{
    public function dispatch(QueryInterface $query): mixed;
}
