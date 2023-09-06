<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use App\Domain\Comparator\Contract\CompareInterface;
use App\Domain\DataTransferObject;
use App\Exceptions\PropertyNotFoundException;
use App\Exceptions\UnexpectedClassException;
use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @psalm-suppress MixedInferredReturnType
 * @psalm-suppress MixedReturnStatement
 */
final class CompareValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof DataTransferObject) {
            return;
        }

        if (!$constraint instanceof Compare) {
            throw new UnexpectedClassException(Compare::class, $constraint::class);
        }

        try {
            $a = $this->getValue($value, $constraint->a);
        } catch (\Throwable) {
            throw new PropertyNotFoundException($value::class, \is_string($constraint->a) ? $constraint->a : '');
        }

        try {
            $b = $this->getValue($value, $constraint->b);
        } catch (\Throwable) {
            throw new PropertyNotFoundException($value::class, \is_string($constraint->b) ? $constraint->b : '');
        }

        if (!$constraint->comparator->compare($a, $b)) {
            $this->addViolation($value, $constraint, $b);
        }
    }

    private function getValue(
        DataTransferObject $object,
        string | DateTime $target
    ): string | DateTime {
        if (\is_string($target) && property_exists($object::class, $target)) {
            return $object->{$target}; //@phpstan-ignore-line
        }

        return $target;
    }

    private function addViolation(DataTransferObject $command, Compare $constraint, mixed $compared): void
    {
        if (!(\is_string($constraint->a) && property_exists($command::class, $constraint->a))) {
            throw new PropertyNotFoundException($command::class, \is_string($constraint->a) ? $constraint->a : '');
        }

        $this->context->buildViolation($this->message($constraint->comparator))
            ->setParameter(
                '{{ compared_value }}',
                $this->formatValue($constraint->comparator->reverseTransform($compared))
            )
            ->setTranslationDomain('validators')
            ->atPath($constraint->a)
            ->addViolation()
        ;
    }

    private function message(CompareInterface $comparator): string
    {
        return sprintf('validation.comparison.%s', $comparator->comparison()->alias());
    }
}
