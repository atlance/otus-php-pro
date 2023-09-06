<?php

declare(strict_types=1);

namespace App\Core\Domain\Contracts;

use App\Core\Contracts\ArrayableInterface;

interface EntityInterface extends ColumnNamesInterface, TableNameInterface, ArrayableInterface
{
}
