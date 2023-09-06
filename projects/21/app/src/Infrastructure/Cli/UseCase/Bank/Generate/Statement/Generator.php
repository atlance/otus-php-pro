<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\UseCase\Bank\Generate\Statement;

use App\Domain\Event\UseCase\Bank\Statement\Created\Subscriber\Generate\Contract\GeneratorInterface;
use App\Infrastructure\Cli\Console\Factory\InputOptionFactory;
use App\Infrastructure\Cli\Console\Runner\Contract\RunnerInterface;

final class Generator implements GeneratorInterface
{
    public function __construct(private readonly RunnerInterface $runner)
    {
    }

    public function generate(string $id, ?int $timeout = null): void
    {
        $this->runner->run(Command::NAME, InputOptionFactory::create(['id' => $id]), true, $timeout);
    }
}
