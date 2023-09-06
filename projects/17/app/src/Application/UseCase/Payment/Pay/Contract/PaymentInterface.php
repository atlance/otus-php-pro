<?php

declare(strict_types=1);

namespace App\Application\UseCase\Payment\Pay\Contract;

use App\Domain\VO\Money;
use Symfony\Component\Uid\UuidV7;

interface PaymentInterface
{
    public function getId(): UuidV7;

    public function getStatus(): string;

    public function getAmount(): ?Money\Amount;
}
