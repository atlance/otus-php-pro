<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Console\Runner\Contract;

interface RunnerInterface
{
    /**
     * @param float|null $timeout in seconds
     */
    public function run(string $name, array $args = [], bool $async = true, ?float $timeout = null): void;
}
