<?php

declare(strict_types=1);

namespace App\Core\Validator;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class ViolationBuilder
{
    public static function build(
        ExecutionContextInterface $context,
        string $message,
        array $parameters = [],
        ?string $atPath = null
    ): void {
        if (\is_string($atPath)) {
            $context->buildViolation($message, $parameters)
                ->setTranslationDomain('validators')
                ->atPath($atPath)
                ->addViolation()
            ;

            return;
        }

        $context->buildViolation($message, $parameters)->setTranslationDomain('validators')->addViolation();
    }
}
