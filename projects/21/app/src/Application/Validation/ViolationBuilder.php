<?php

declare(strict_types=1);

namespace App\Application\Validation;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class ViolationBuilder
{
    public static function build(ExecutionContextInterface $context, string $message, array $parameters = []): void
    {
        $context
            ->buildViolation($message, $parameters)
            ->setTranslationDomain('validators')
            ->addViolation();
    }
}
