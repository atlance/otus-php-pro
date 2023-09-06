<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Response;

use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class Forbidden implements Contract\FactoryInterface
{
    /** {@inheritdoc} */
    public function create(ResponseInterface $response): PaymentInterface
    {
        throw new AccessDeniedHttpException();
    }

    public static function statusCode(): string
    {
        return (string) Response::HTTP_FORBIDDEN;
    }
}
