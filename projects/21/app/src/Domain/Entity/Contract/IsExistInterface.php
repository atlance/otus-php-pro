<?php

declare(strict_types=1);

namespace App\Domain\Entity\Contract;

use App\Domain\Entity\Contract\Existence\IsExistByCriteriaInterface;
use App\Domain\Entity\Contract\Existence\IsExistColumnInterface;
use App\Domain\Entity\Contract\Existence\IsExistTableInterface;

interface IsExistInterface extends IsExistTableInterface, IsExistColumnInterface, IsExistByCriteriaInterface
{
}
