<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class BankCardExpiry extends Constraint
{
    public string $message;
}
