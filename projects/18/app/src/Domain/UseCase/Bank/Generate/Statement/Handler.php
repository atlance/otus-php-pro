<?php

declare(strict_types=1);

namespace App\Domain\UseCase\Bank\Generate\Statement;

use App\Domain\Bus\Contract\Command\HandlerInterface;
use App\Domain\Bus\Contract\Event;
use App\Domain\Entity\Bank\StatementRepository;
use App\Domain\UseCase\Bank\Generate\Statement\Event\Created;

final class Handler implements HandlerInterface
{
    public function __construct(
        private readonly StatementRepository $repository,
        private readonly Contract\GeneratorInterface $generator,
        private readonly Event\BusInterface $bus
    ) {
    }

    public function handle(Command $command): void
    {
        $object = $this->repository->findOneBy([
            'email' => $command->email,
            'startDate' => $command->startDate,
            'endDate' => $command->endDate,
        ]);

        if (null === $object) {
            $this->generator->generate($command);
        }

        $object = $this->repository->getBy($command->email, $command->startDate, $command->endDate);

        $this->bus->dispatch(
            Created::fromArray([
                'id' => $object->getId(),
                'email' => $object->getEmail(),
                'startDate' => $object->getStartDate(),
                'endDate' => $object->getEndDate(),
            ])
        );
    }
}
