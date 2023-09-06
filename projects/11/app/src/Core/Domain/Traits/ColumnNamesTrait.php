<?php

declare(strict_types=1);

namespace App\Core\Domain\Traits;

trait ColumnNamesTrait
{
    /** @psalm-suppress LessSpecificImplementedReturnType */
    public function getColumnNames(): array
    {
        return array_keys(get_class_vars(static::class));
    }
}
