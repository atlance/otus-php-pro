<?php

declare(strict_types=1);

namespace App\Application\UseCase\Create;

use App\Application\DataTransferObject;
use App\Application\Validation\Constraint;
use App\Domain\Entity\Card\Contract\BankCardInterface;
use App\Domain\Entity\Card\VO;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends DataTransferObject implements BankCardInterface
{
    /** @var non-empty-string */
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'validation.message.not_null'),
        new Assert\Regex(VO\Number::PATTERN, message: 'validation.bank_card.number'),
        new Assert\Luhn(message: 'validation.bank_card.number'),
    ])]
    public string $number;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\Regex(VO\Cvv::PATTERN, message: 'validation.bank_card.cvv')]
    public string $cvv;

    /** @var non-empty-string */
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'validation.message.not_null'),
        new Constraint\BankCardExpiry(),
    ])]
    public string $expiry;

    #[Assert\Regex(VO\Holder::PATTERN, message: 'validation.bank_card.holder')]
    public ?string $holder = null;

    public function getNumber(): VO\Number
    {
        return new VO\Number($this->number);
    }

    public function getCvv(): VO\Cvv
    {
        return new VO\Cvv($this->cvv);
    }

    public function getExpiry(): VO\Expiry
    {
        return new VO\Expiry($this->expiry);
    }

    public function getHolder(): ?VO\Holder
    {
        return null === $this->holder ? null : new VO\Holder($this->holder);
    }
}
