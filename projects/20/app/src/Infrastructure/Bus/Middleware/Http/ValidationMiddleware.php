<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Middleware\Http;

use App\Application\Validation\Exception\ValidationProblem;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ValidationStamp;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidationMiddleware implements MiddlewareInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /** @psalm-suppress MixedArgumentTypeCoercion */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        /** @var ValidationStamp|null $validationStamp */
        $validationStamp = $envelope->last(ValidationStamp::class);
        /** @var array|GroupSequence|null $groups */
        $groups = $validationStamp?->getGroups();

        $violations = $this->validator->validate($message, null, $groups);
        if (0 === $violations->count()) {
            return $stack->next()->handle($envelope, $stack);
        }

        throw new ValidationProblem($violations);
    }
}
