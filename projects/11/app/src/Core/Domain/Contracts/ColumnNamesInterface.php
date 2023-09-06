<?php

declare(strict_types=1);

namespace App\Core\Domain\Contracts;

interface ColumnNamesInterface
{
    /**
     * @return array<int, string>
     */
    public function getColumnNames(): array;
}
