<?php

declare(strict_types=1);

namespace App\Application\UseCase\Payment\Pay\Contract;

use App\Domain\VO\Card\Contract\BankCardInterface;

interface PaymentFactoryInterface
{
    public function create(BankCardInterface $card): PaymentInterface;
}
