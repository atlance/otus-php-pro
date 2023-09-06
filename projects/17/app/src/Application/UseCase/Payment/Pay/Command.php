<?php

declare(strict_types=1);

namespace App\Application\UseCase\Payment\Pay;

use App\Application\DataTransferObject;
use App\Application\Validation\Constraint;
use App\Domain\Entity\Order;
use App\Domain\VO\Card;
use App\Domain\VO\Card\Contract\BankCardInterface;
use App\Domain\VO\Money;
use Symfony\Component\Validator\Constraints as Assert;

final class Command extends DataTransferObject implements BankCardInterface
{
    /** @var non-empty-string */
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'validation.message.not_null'),
        new Assert\Regex(Card\Number::PATTERN, message: 'validation.bank_card.number'),
        new Assert\Luhn(),
    ])]
    public string $number;

    /** @var non-empty-string */
    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\Regex(Card\Cvv::PATTERN, message: 'validation.bank_card.cvv')]
    public string $cvv;

    /** @var non-empty-string */
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'validation.message.not_null'),
        new Constraint\BankCardExpiry(),
    ])]
    public string $expiry;

    /** @var non-empty-string|null */
    #[Assert\Regex(Card\Holder::PATTERN, message: 'validation.bank_card.holder')]
    public ?string $holder = null;

    /** @var non-empty-string */
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'validation.message.not_null'),
        new Assert\Regex(Order\VO\Number::PATTERN, message: 'validation.payment.order_number'),
        new Constraint\Id(Order\Order::TABLE_NAME, column: 'number', isExists: false),
    ])]
    public string $order_number;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\Type('numeric', message: 'validation.message.not_number')]
    #[Assert\Positive(message: 'validation.payment.sum')]
    public string $amount;

    public function getNumber(): Card\Number
    {
        return new Card\Number($this->number);
    }

    public function getCvv(): Card\Cvv
    {
        return new Card\Cvv($this->cvv);
    }

    public function getExpiry(): Card\Expiry
    {
        return new Card\Expiry($this->expiry);
    }

    public function getHolder(): ?Card\Holder
    {
        return null === $this->holder ? null : new Card\Holder($this->holder);
    }

    public function getOrderNumber(): Order\VO\Number
    {
        return new Order\VO\Number($this->order_number);
    }

    public function setAmount(string | int | float $value): void
    {
        $this->amount = str_replace(',', '.', (string) $value);
    }

    public function getMoneyAmount(): Money\Amount
    {
        return new Money\Amount($this->amount);
    }
}
