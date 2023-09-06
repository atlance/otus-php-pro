<?php

declare(strict_types=1);

namespace App\Core\Validator\Constraints;

use App\Core\Exceptions\UnexpectedClassException;
use App\Core\Validator\ViolationBuilder;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ArrayKeysValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ArrayKeys) {
            throw new UnexpectedClassException(ArrayKeys::class);
        }

        if (!\is_array($value)) {
            return;
        }

        $unavailable = array_filter(
            $value,
            static fn (string $key) => !\in_array($key, $constraint->keys, true),
            \ARRAY_FILTER_USE_KEY
        );

        if (0 < \count($unavailable)) {
            ViolationBuilder::build(
                $this->context,
                sprintf(
                    'Недопустимо: %s. Возможны: %s.',
                    implode(', ', array_keys($unavailable)),
                    implode(', ', $constraint->keys),
                )
            );
        }
    }
}
