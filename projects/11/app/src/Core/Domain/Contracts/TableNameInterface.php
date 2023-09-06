<?php

declare(strict_types=1);

namespace App\Core\Domain\Contracts;

interface TableNameInterface
{
    public static function tableName(): string;
}
