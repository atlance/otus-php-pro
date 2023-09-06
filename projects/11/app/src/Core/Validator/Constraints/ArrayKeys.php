<?php

declare(strict_types=1);

namespace App\Core\Validator\Constraints;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class ArrayKeys extends Constraint
{
    #[HasNamedArguments]
    public function __construct(
        public array $keys,
        array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }
}
