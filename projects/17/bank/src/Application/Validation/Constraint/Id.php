<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Id extends Constraint
{
    public string $message = 'validation.message.not_exists';

    #[HasNamedArguments]
    public function __construct(
        public string $table,
        public string $column = 'id',
        array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }
}
