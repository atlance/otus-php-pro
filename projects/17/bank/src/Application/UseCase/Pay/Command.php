<?php

declare(strict_types=1);

namespace App\Application\UseCase\Pay;

use App\Application\DataTransferObject;
use App\Application\Validation\Constraint;
use App\Domain\Entity\Payment\Contract\PayInterface;
use App\Domain\Entity\Payment\Payment;
use App\Domain\Entity\VO;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

class Command extends DataTransferObject implements PayInterface
{
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'validation.message.not_null'),
        new Assert\Uuid(message: 'validation.pay.payment_id'),
        new Constraint\Id(Payment::TABLE_NAME),
    ])]
    public string $paymentId;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\Positive(message: 'validation.pay.amount')]
    public string $amount;

    public function getPaymentId(): UuidV7
    {
        return new UuidV7($this->paymentId);
    }

    public function setAmount(string | int | float $value): void
    {
        $this->amount = str_replace(',', '.', (string) $value);
    }

    public function getAmount(): VO\Money\Amount
    {
        return new VO\Money\Amount($this->amount);
    }
}
