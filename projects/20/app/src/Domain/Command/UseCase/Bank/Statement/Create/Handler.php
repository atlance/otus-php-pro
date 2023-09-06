<?php

declare(strict_types=1);

namespace App\Domain\Command\UseCase\Bank\Statement\Create;

use App\Domain\Bus\Contract\Command\HandlerInterface;
use App\Domain\Bus\Contract\Event;
use App\Domain\Entity\Bank\StatementRepository;
use App\Domain\Entity\Bank\Status;
use App\Domain\Entity\Contract\FlusherInterface;
use App\Domain\Event\UseCase\Bank\Statement\Created;

final class Handler implements HandlerInterface
{
    public function __construct(
        private readonly StatementRepository $repository,
        private readonly FlusherInterface $flusher,
        private readonly Event\BusInterface $bus
    ) {
    }

    public function handle(Command $command): void
    {
        $object = $this->repository->createIfNotExists($command);

        if (Status::GENERATION === $object->getStatus()) {
            $this->flusher->flush();

            $this->bus->dispatch(
                Created::fromArray([
                    'id' => $object->getId(),
                    'email' => $object->getEmail()->getValue(),
                    'startAt' => $object->getStartAt()->format('Y-m-d'),
                    'endAt' => $object->getEndAt()->format('Y-m-d'),
                ])
            );
        }
    }
}
