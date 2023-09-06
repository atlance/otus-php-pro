<?php

declare(strict_types=1);

namespace App\Core\Validator;

use App\Core\Command\AbstractCommand;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CommandValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(AbstractCommand $object): ConstraintViolationListInterface
    {
        return $this->validator->validate($object);
    }
}
