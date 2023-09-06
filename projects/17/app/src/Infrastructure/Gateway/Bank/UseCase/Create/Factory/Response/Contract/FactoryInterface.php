<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Response\Contract;

use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Application\Validation\Exception\ValidationProblemArray;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface FactoryInterface
{
    /**
     * @throws ValidationProblemArray
     */
    public function create(ResponseInterface $response): PaymentInterface;

    public static function statusCode(): string;
}
