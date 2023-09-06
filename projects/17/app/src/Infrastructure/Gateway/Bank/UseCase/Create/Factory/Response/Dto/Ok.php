<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Response\Dto;

use App\Application\DataTransferObject;
use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Domain\VO\Money;
use Symfony\Component\Uid\UuidV7;

class Ok extends DataTransferObject implements PaymentInterface
{
    public UuidV7 $id;
    public string $status;
    public ?Money\Amount $amount;
    public string $created_at;

    public function setId(string $id): void
    {
        $this->id = new UuidV7($id);
    }

    /**
     * @param array{value:string} $dataset
     */
    public function setAmount(array $dataset): void
    {
        $this->amount = new Money\Amount($dataset['value']);
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAmount(): ?Money\Amount
    {
        return $this->amount;
    }
}
