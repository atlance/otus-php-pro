<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Pay\Factory\Response;

use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Application\Validation\Dto\BadRequestMessage;
use App\Application\Validation\Exception\ValidationProblemArray;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class BadRequest implements Contract\FactoryInterface
{
    /** {@inheritdoc} */
    public function create(ResponseInterface $response): PaymentInterface
    {
        throw new ValidationProblemArray(BadRequestMessage::fromHashtable($response->toArray(false)));
    }

    public static function statusCode(): string
    {
        return (string) Response::HTTP_BAD_REQUEST;
    }
}
