<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use App\Exceptions\UnexpectedValueException;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class Criteria extends Constraint
{
    public string $message;

    #[HasNamedArguments]
    public function __construct(
        public string $table,
        /** @var string[] */
        public array $columns,
        /** @var string[] */
        public array $properties,
        ?string $message = null,
        public bool $isExists = true,
        array $groups = null,
        mixed $payload = null,
    ) {
        if (null === $message) {
            $message = false === $this->isExists ? 'validation.message.exists' : 'validation.message.not_exists';
        }

        $this->message = $message;

        $this->assert();

        parent::__construct([], $groups, $payload);
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    private function assert(): void
    {
        if (\count($this->columns) !== \count($this->properties)) {
            throw new UnexpectedValueException('count columns !== count properties');
        }
    }
}
