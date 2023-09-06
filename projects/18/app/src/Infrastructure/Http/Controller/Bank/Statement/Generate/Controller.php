<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Bank\Statement\Generate;

use App\Domain\Bus\Contract\Command\BusInterface;
use App\Domain\UseCase\Bank\Generate\Statement\Command;
use App\Infrastructure\Http\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/bank/statement/generate', name: self::class, methods: ['POST'], format: 'application/json')]
final class Controller extends AbstractController
{
    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function __invoke(Request $request, BusInterface $bus): JsonResponse
    {
        $bus->dispatch(Command::fromArray($this->content($request)));

        return $this->json(['status' => 'ok']);
    }
}
