<?php

declare(strict_types=1);

namespace App\Core\Application\Validation\Constraints;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class ArrayKeysOfType extends Constraint
{
    /**
     * @param string                        $type
     * @param array<array-key, string>|null $groups
     * @param mixed|null                    $payload
     */
    #[HasNamedArguments]
    public function __construct(public string $type, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
    }
}
