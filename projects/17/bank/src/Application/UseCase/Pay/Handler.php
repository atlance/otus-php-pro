<?php

declare(strict_types=1);

namespace App\Application\UseCase\Pay;

use App\Domain\Contract\FlusherInterface;
use App\Domain\Entity\Payment\Payment;
use App\Domain\Entity\Payment\PaymentRepository;

final class Handler
{
    public function __construct(
        private readonly PaymentRepository $repository,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function handle(Command $command): Payment
    {
        $payment = $this->repository->get($command->getPaymentId());

        if ($payment->isPending()) {
            $this->repository->add($payment->pay($command->getAmount()));

            $this->flusher->flush();
        }

        return $payment;
    }
}
