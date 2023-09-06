<?php

declare(strict_types=1);

namespace App\EventStorage\Presentation\Controller\Event\Update;

use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Controller\Attributes\Post;
use App\Core\Presentation\Controller\Attributes\Requirements\UuidPattern;
use App\EventStorage\Application\UseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Post('/update/{id}', name: self::class, requirements: ['id' => UuidPattern::VALUE])]
final class Controller extends AbstractController
{
    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function __invoke(string $id, Request $request, UseCase\Event\Update\Handler $handler): JsonResponse
    {
        $command = new UseCase\Event\Update\Command(array_merge(['id' => $id], $this->getContent($request)));
        $this->validate($command);

        return $this->json($handler->handle($command));
    }
}
