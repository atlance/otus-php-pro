<?php

declare(strict_types=1);

namespace App\Application\Validation\Constraint;

use App\Application\Validation\ViolationBuilder;
use App\Domain\VO\Card\Expiry;
use App\Exceptions\Assert\Assert;
use App\Exceptions\UnexpectedClassException;
use App\Exceptions\UnexpectedValueException;
use Psr\Clock\ClockInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class BankCardExpiryValidator extends ConstraintValidator
{
    public function __construct(private readonly ClockInterface $clock)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof BankCardExpiry) {
            throw new UnexpectedClassException(BankCardExpiry::class, $constraint::class);
        }

        if (null === $value) {
            return;
        }

        if (!$this->isString($value)) {
            return;
        }

        if (null === ($expiry = $this->createExpiry($value))) {
            return;
        }

        if ($expiry->toDateTime() > $this->clock->now()) {
            return;
        }

        ViolationBuilder::build($this->context, 'validation.bank_card.expiration_date_expired');
    }

    private function isString(mixed $value): bool
    {
        try {
            Assert::string($value);

            return true;
        } catch (UnexpectedValueException) {
            ViolationBuilder::build($this->context, 'validation.message.not_string');

            return false;
        }
    }

    private function createExpiry(mixed $value): ?Expiry
    {
        try {
            return new Expiry($value);
        } catch (UnexpectedValueException) {
            ViolationBuilder::build($this->context, 'validation.bank_card.expiration_date_format');

            return null;
        }
    }
}
