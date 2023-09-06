<?php

declare(strict_types=1);

namespace App\Domain\Entity\Payment\Contract;

use App\Domain\Entity\VO;
use Symfony\Component\Uid\UuidV7;

interface PayInterface
{
    public function getPaymentId(): UuidV7;

    public function getAmount(): VO\Money\Amount;
}
