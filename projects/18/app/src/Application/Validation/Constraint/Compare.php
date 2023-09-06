<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use App\Domain\Comparator\Contract\CompareInterface;
use App\Domain\Comparator\Contract\TransformerInterface;
use DateTime;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
final class Compare extends Constraint
{
    public string $message = 'validation.date.min_max';

    #[HasNamedArguments]
    public function __construct(
        public string | DateTime $a,
        public string | DateTime $b,
        public CompareInterface & TransformerInterface $comparator,
        array $groups = null,
        mixed $payload = null,
    ) {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        parent::__construct([], $groups, $payload);
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
