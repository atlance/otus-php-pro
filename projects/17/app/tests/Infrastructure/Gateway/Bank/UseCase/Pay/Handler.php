<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Gateway\Bank\UseCase\Pay;

use App\Application\UseCase\Payment\Pay\Contract\PayInterface;
use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Domain\VO\Money\Amount;
use App\Infrastructure\Gateway\Bank\UseCase\Pay\Factory\Response\Dto;

final class Handler implements PayInterface
{
    public function pay(PaymentInterface $payment, Amount $amount): PaymentInterface
    {
        return Dto\Ok::fromHashtable([
            'id' => $payment->getId()->toRfc4122(),
            'status' => 'succeeded',
            'amount' => [
                'value' => (string) $amount,
                'currency' => 'RUB',
            ],
            'created_at' => (new \DateTime())->format(\DateTime::ATOM),
        ]);
    }
}
