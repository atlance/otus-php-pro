<?php

declare(strict_types=1);

namespace App\Exceptions;

class TableNotFoundException extends \DomainException
{
    public function __construct(string $tableName)
    {
        parent::__construct(sprintf('Table `%s` - not found', $tableName));
    }
}
