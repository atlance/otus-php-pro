<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\UseCase\Bank\Generate\Statement;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: Command::NAME)]
final class Command extends BaseCommand
{
    public const NAME = 'bank:statement:generate';
    public const SLEEP_SECONDS = 3;

    public function __construct()
    {
        parent::__construct(self::NAME);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->generate($input->getOptions());

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setDefinition(
                new InputDefinition([
                    new InputOption(
                        'email',
                        mode: InputOption::VALUE_REQUIRED,
                        description: 'Example: --email="foo@gmail.com".'
                    ),
                    new InputOption(
                        'startDate',
                        mode: InputOption::VALUE_REQUIRED,
                        description: 'Date in format Y-m-d. Example: --startDate="2023-06-01".'
                    ),
                    new InputOption(
                        'endDate',
                        mode: InputOption::VALUE_REQUIRED,
                        description: 'Date in format Y-m-d. Example: --end="2023-06-05".'
                    ),
                ])
            );
    }

    /**
     * Emulating creating a bank statement.
     */
    private function generate(array $arguments): void
    {
        sleep(self::SLEEP_SECONDS);
        unset($arguments);
    }
}
