<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly JsonEncoder $encoder,
    ) {
    }

    public function content(Request $request): array
    {
        return (array) $this->encoder->decode($request->getContent(), JsonEncoder::FORMAT);
    }

    final public function json(
        mixed $data,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
        array $context = []
    ): JsonResponse {
        return new JsonResponse(
            $this->serializer->serialize(['data' => $data], JsonEncoder::FORMAT, $context),
            $statusCode,
            $headers,
            true
        );
    }
}
