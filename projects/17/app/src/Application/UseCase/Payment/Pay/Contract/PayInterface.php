<?php

declare(strict_types=1);

namespace App\Application\UseCase\Payment\Pay\Contract;

use App\Domain\VO\Money\Amount;

interface PayInterface
{
    public function pay(PaymentInterface $payment, Amount $amount): PaymentInterface;
}
