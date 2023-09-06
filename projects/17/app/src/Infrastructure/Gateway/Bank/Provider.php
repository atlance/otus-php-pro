<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank;

use App\Application\UseCase\Payment\Pay\Contract\PayInterface;
use App\Application\UseCase\Payment\Pay\Contract\PaymentFactoryInterface;
use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Application\UseCase\Payment\Pay\Contract\PaymentProviderInterface;
use App\Domain\VO\Card\Contract\BankCardInterface;
use App\Domain\VO\Money\Amount;

final class Provider implements PaymentProviderInterface
{
    public function __construct(
        private readonly PaymentFactoryInterface $factory,
        private readonly PayInterface $payer,
    ) {
    }

    public function pay(BankCardInterface $card, Amount $amount): PaymentInterface
    {
        return $this->payer->pay($this->factory->create($card), $amount);
    }
}
