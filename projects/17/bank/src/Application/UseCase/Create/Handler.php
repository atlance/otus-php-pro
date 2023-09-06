<?php

declare(strict_types=1);

namespace App\Application\UseCase\Create;

use App\Domain\Contract\FlusherInterface;
use App\Domain\Entity\Card\CardRepository;
use App\Domain\Entity\Payment\Payment;
use App\Domain\Entity\Payment\PaymentRepository;
use App\Domain\Entity\Payment\Status;

final class Handler
{
    public function __construct(
        private readonly CardRepository $cardRepository,
        private readonly PaymentRepository $payRepository,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function handle(Command $command): Payment
    {
        $card = $this->cardRepository->findOneBy(['number' => $command->getNumber()])
            ?? $this->cardRepository->create($command);

        $payment = $this->payRepository->findOneBy(['card' => $card, 'status' => Status::PENDING])
            ?? $this->payRepository->create($card);

        $this->flusher->flush();

        return $payment;
    }
}
