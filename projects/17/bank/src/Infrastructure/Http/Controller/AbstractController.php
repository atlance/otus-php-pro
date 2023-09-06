<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Validation\Exception\ValidationProblem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
abstract class AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly JsonEncoder $encoder,
    ) {
    }

    public function content(Request $request): array
    {
        return (array) $this->encoder->decode($request->getContent(), JsonEncoder::FORMAT);
    }

    /**
     * @throws ValidationProblem
     */
    public function validate($command): void
    {
        $violations = $this->validator->validate($command);
        if (0 === $violations->count()) {
            return;
        }

        throw new ValidationProblem($violations);
    }

    /** @psalm-suppress MixedArgumentTypeCoercion */
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

    final public function emptyJson(int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(status: $statusCode);
    }
}
