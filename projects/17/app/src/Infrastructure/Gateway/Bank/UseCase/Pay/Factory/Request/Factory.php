<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Pay\Factory\Request;

use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Domain\VO\Money\Amount;

final class Factory implements Contract\FactoryInterface
{
    public function create(PaymentInterface $payment, Amount $amount): array
    {
        return [
            'json' => [
                'paymentId' => $payment->getId(),
                'amount' => $amount->getConvertedValue(),
            ],
        ];
    }
}
