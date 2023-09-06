<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Infrastructure\Http\Controller\Contract\ControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractController implements ControllerInterface
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    final public function json(
        mixed $data,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
        array $context = []
    ): JsonResponse {
        return new JsonResponse(
            $this->serializer->serialize($data, JsonEncoder::FORMAT, $context),
            $statusCode,
            $headers,
            true
        );
    }

    final public function notFound(): JsonResponse
    {
        return new JsonResponse(status: Response::HTTP_NOT_FOUND);
    }
}
