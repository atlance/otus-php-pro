<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use App\Domain\Entity\Contract\Existence\IsExistByCriteriaInterface;
use App\Exceptions\PropertyNotFoundException;
use App\Exceptions\UnexpectedClassException;
use App\Exceptions\UnexpectedValueException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class CriteriaValidator extends ConstraintValidator
{
    public function __construct(private readonly IsExistByCriteriaInterface $exister)
    {
    }

    /**
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedArgument
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!\is_object($value)) {
            throw new UnexpectedValueException();
        }

        if (!$constraint instanceof Criteria) {
            throw new UnexpectedClassException(Criteria::class, $constraint::class);
        }

        $criteria = [];
        foreach ($constraint->properties as $i => $property) {
            if (!property_exists($value, $property)) {
                throw new PropertyNotFoundException($value::class, sprintf('public property %s', $property));
            }

            $data = $value->{$property}; // @phpstan-ignore-line

            if (null === $data) {
                return;
            }

            $criteria[$constraint->columns[$i]] = $data;
        }

        if ($constraint->isExists === $this->exister->isExistByCriteria($constraint->table, $criteria)) {
            return;
        }

        foreach ($constraint->properties as $property) {
            $this->context->buildViolation($constraint->message)
                ->setTranslationDomain('validators')
                ->atPath($property)
                ->addViolation();
        }
    }
}
