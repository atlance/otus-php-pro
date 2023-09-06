<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Pay\Factory\Response;

use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class Ok implements Contract\FactoryInterface
{
    /** {@inheritdoc} */
    public function create(ResponseInterface $response): PaymentInterface
    {
        return Dto\Ok::fromHashtable($response->toArray()['data']);
    }

    public static function statusCode(): string
    {
        return (string) Response::HTTP_OK;
    }
}
