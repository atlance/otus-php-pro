<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Validate;

use App\Application\UseCase;
use App\Core\Infrastructure\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/validate', name: self::class, methods: ['POST'])]
final class Controller extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $this->validate(new UseCase\Validation\Command($this->content($request)));

        return $this->emptyJson();
    }
}
