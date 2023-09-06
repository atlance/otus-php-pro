<?php

declare(strict_types=1);

namespace App\Core\Application\Validation\Constraints;

use App\Core\Application\Validation\ViolationBuilder;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ArrayKeysOfTypeValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ArrayKeysOfType) {
            throw new UnexpectedTypeException($constraint, ArrayKeysOfType::class);
        }

        if (!\is_array($value)) {
            return;
        }

        $isType = sprintf('is_%s', $constraint->type);
        $unavailable = array_filter($value, static fn (mixed $key) => !$isType($key), \ARRAY_FILTER_USE_KEY);

        if (0 < \count($unavailable)) {
            ViolationBuilder::build(
                $this->context,
                sprintf(
                    'Недопустимо: %s. В качестве ключей допустим только %s-тип значений.',
                    implode(', ', array_keys($unavailable)),
                    $constraint->type
                )
            );
        }
    }
}
