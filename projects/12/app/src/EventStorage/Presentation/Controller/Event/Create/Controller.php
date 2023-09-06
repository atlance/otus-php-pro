<?php

declare(strict_types=1);

namespace App\EventStorage\Presentation\Controller\Event\Create;

use App\Core\Presentation\Controller\AbstractController;
use App\EventStorage\Application\UseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/create', name: self::class, methods: ['POST'])]
final class Controller extends AbstractController
{
    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function __invoke(Request $request, UseCase\Event\Create\Handler $handler): JsonResponse
    {
        $command = new UseCase\Event\Create\Command($this->getContent($request));
        $this->validate($command);

        return $this->json($handler->handle($command));
    }
}
