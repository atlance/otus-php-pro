<?php

declare(strict_types=1);

namespace App\Application\UseCase\Payment\Pay;

use App\Domain\Contract\FlusherInterface;
use App\Domain\Entity\Order\Order;
use App\Domain\Entity\Order\OrderRepository;

final class Handler
{
    public function __construct(
        private readonly Contract\PaymentProviderInterface $provider,
        private readonly OrderRepository $repository,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function handle(Command $command): Order
    {
        $payment = $this->provider->pay($command, $command->getMoneyAmount());
        $order = $this->repository->create($command->getOrderNumber(), $payment->getId(), $command->getMoneyAmount());

        $this->flusher->flush();

        return $order;
    }
}
