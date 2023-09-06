<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Pay\Factory\Request\Contract;

use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Domain\VO\Money\Amount;

interface FactoryInterface
{
    public function create(PaymentInterface $payment, Amount $amount): array;
}
