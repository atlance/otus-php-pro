<?php

declare(strict_types=1);

namespace App\Domain\Event\UseCase\Bank\Statement\Created\Subscriber\Generate;

use App\Domain\Bus\Contract\Event\HandlerInterface;
use App\Domain\Event\UseCase\Bank\Statement\Created;

final class Handler implements HandlerInterface
{
    public function __construct(private readonly Contract\GeneratorInterface $generator)
    {
    }

    public function handle(Created $event): void
    {
        $this->generator->generate($event->id, 30);
    }
}
