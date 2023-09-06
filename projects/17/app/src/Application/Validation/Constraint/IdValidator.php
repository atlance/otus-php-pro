<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use App\Application\Validation\Constraint\Contract\IsExistsWithCriteriaInterface;
use App\Application\Validation\ViolationBuilder;
use App\Exceptions\UnexpectedClassException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class IdValidator extends ConstraintValidator
{
    public function __construct(private readonly IsExistsWithCriteriaInterface $checker)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Id) {
            throw new UnexpectedClassException(Id::class, $constraint::class);
        }

        if (null === $value) {
            return;
        }

        if ($constraint->isExists === $this->checker->isExists($constraint->table, [$constraint->column => $value])) {
            return;
        }

        ViolationBuilder::build($this->context, $constraint->message);
    }
}
