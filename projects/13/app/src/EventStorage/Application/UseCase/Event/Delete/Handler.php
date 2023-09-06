<?php

declare(strict_types=1);

namespace App\EventStorage\Application\UseCase\Event\Delete;

use App\EventStorage\Infrastructure\Database\Pdo\Event\DataMapper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class Handler
{
    public function __construct(private readonly DataMapper $storage)
    {
    }

    public function handle(string $id): void
    {
        $object = $this->storage->find($id);
        if (null === $object) {
            throw new NotFoundHttpException();
        }

        $this->storage->delete($object);
    }
}
