<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\UseCase\Bank\Generate\Statement;

use App\Domain\Bus\Contract\Event\BusInterface;
use App\Domain\Entity\Bank\Statement;
use App\Domain\Entity\Bank\StatementRepository;
use App\Domain\Entity\Bank\Status;
use App\Domain\Entity\Contract\FlusherInterface;
use App\Domain\Event\UseCase\Bank\Statement\Generated;
use App\Exceptions\Assert\Assert;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Uid\UuidV7;

#[AsCommand(name: Command::NAME)]
final class Command extends BaseCommand
{
    public const NAME = 'bank:statement:generate';
    public const SLEEP_SECONDS = 5;

    public function __construct(
        private readonly LockFactory $lockFactory,
        private readonly StatementRepository $repository,
        private readonly FlusherInterface $flusher,
        private readonly BusInterface $bus
    ) {
        parent::__construct(self::NAME);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = $input->getOption('id');

        try {
            Assert::string($id);

            $object = $this->repository->get(new UuidV7($id));
        } catch (\Throwable) {
            return self::INVALID;
        }

        $lock = $this->lockFactory->createLock(sprintf('generation_id_%s', $object->getId()), 60);
        $lock->acquire(true);

        if (Status::GENERATED !== $object->getStatus()) {
            $this->generate();

            $this->repository->add($object->toGeneratedStatus());

            $this->flusher->flush();

            $this->bus->dispatch(Generated::fromArray([
                'id' => $object->getId(),
                'email' => $object->getEmail(),
                'startAt' => $object->getStartAt(),
                'endAt' => $object->getEndAt(),
                'status' => $object->getStatus(),
            ]));
        }

        $lock->release();

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setDefinition(
                new InputDefinition([
                    new InputOption(
                        'id',
                        mode: InputOption::VALUE_REQUIRED,
                        description: 'Example: --id="0188acae-429e-7d18-80d1-36d42bd7044a".'
                    ),
                ])
            );
    }

    /**
     * Emulating generation a bank statement.
     */
    private function generate(): void
    {
        sleep(self::SLEEP_SECONDS);
    }
}
