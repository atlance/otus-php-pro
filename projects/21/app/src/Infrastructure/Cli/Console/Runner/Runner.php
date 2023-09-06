<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Console\Runner;

use Symfony\Component\Process\Process;

final class Runner implements Contract\RunnerInterface
{
    /**
     * @param string $appDir
     * @param float  $timeout in seconds
     */
    public function __construct(private readonly string $appDir, private readonly float $timeout = 300)
    {
    }

    /** {@inheritdoc} */
    public function run(string $name, array $args = [], bool $async = true, ?float $timeout = null): void
    {
        $process = new Process(
            command: array_merge(['php', 'bin/console', $name], $args),
            cwd: $this->appDir,
            timeout: $timeout ?? $this->timeout
        );
        $process->disableOutput();
        $process->start();

        if ($async) {
            return;
        }

        $process->wait();
    }
}
