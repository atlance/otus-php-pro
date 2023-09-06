<?php

declare(strict_types=1);

namespace App\Application\UseCase\Payment\Pay\Contract;

use App\Domain\VO\Card\Contract\BankCardInterface;
use App\Domain\VO\Money\Amount;

interface PaymentProviderInterface
{
    public function pay(BankCardInterface $card, Amount $amount): PaymentInterface;
}
