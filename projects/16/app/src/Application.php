<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;

final class Application extends BaseApplication
{
    /**
     * @param iterable<Command> $commands
     */
    public function __construct(string $name, string $version, iterable $commands = [])
    {
        parent::__construct($name, $version);

        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}
