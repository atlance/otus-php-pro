<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Id extends Constraint
{
    public string $message;

    #[HasNamedArguments]
    public function __construct(
        public string $table,
        public string $column = 'id',
        public bool $isExists = true,
        array $groups = null,
        mixed $payload = null,
    ) {
        $this->message = false === $this->isExists ? 'validation.message.exists' : 'validation.message.not_exists';

        parent::__construct([], $groups, $payload);
    }
}
