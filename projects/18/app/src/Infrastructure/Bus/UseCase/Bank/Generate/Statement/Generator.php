<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\UseCase\Bank\Generate\Statement;

use App\Domain\UseCase\Bank\Generate\Statement\Command;
use App\Domain\UseCase\Bank\Generate\Statement\Contract\GeneratorInterface;
use App\Infrastructure\Cli\Console\Factory\InputOptionFactory;
use App\Infrastructure\Cli\Console\Runner\Contract\RunnerInterface;
use App\Infrastructure\Cli\UseCase\Bank\Generate\Statement as Cli;

class Generator implements GeneratorInterface
{
    public function __construct(private readonly RunnerInterface $runner)
    {
    }

    public function generate(Command $command): void
    {
        $this->runner->run(
            name: Cli\Command::NAME,
            args: InputOptionFactory::create($command->toArray()),
            async: false,
            timeout: $command->getTtl()
        );
    }
}
