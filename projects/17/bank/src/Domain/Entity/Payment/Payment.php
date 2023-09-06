<?php

declare(strict_types=1);

namespace App\Domain\Entity\Payment;

use App\Domain\Entity\Card\Card;
use App\Domain\Entity\VO;
use App\Infrastructure\Database\Doctrine\Dbal\Type\ColumnType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\UuidV7;

#[
    ORM\Entity,
    ORM\Table(name: self::TABLE_NAME, options: ['comment' => 'Платежи.']),
]
class Payment
{
    final public const TABLE_NAME = 'payments';

    #[
        ORM\Id,
        ORM\Column(name: 'id', type: ColumnType::UUID, options: ['comment' => 'Идентификатор.'])
    ]
    private UuidV7 $id;

    #[ORM\ManyToOne(targetEntity: Card::class)]
    #[ORM\JoinColumn(name: 'card_id', referencedColumnName: 'id', nullable: false)]
    private Card $card;

    #[ORM\Column(
        name: 'status',
        enumType: Status::class,
        options: ['comment' => 'Статус платежа.', 'default' => Status::PENDING]
    )]
    private Status $status;

    #[ORM\Column(name: 'amount', type: ColumnType::MONEY_AMOUNT, nullable: true, options: ['comment' => 'Сумма платежа.'])]
    private ?VO\Money\Amount $amount;

    public function __construct(Card $card, Status $status = Status::PENDING, UuidV7 $id = new UuidV7())
    {
        $this->card = $card;
        $this->status = $status;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    #[Ignore]
    public function getCard(): Card
    {
        return $this->card;
    }

    #[Ignore]
    public function isPending(): bool
    {
        return Status::PENDING === $this->status;
    }

    public function getStatus(): string
    {
        return $this->status->alias();
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->id->getDateTime();
    }

    public function getAmount(): ?VO\Money\Amount
    {
        return $this->amount;
    }

    public function pay(VO\Money\Amount $amount): self
    {
        if (null !== $this->amount && $this->amount->isEquals($amount)) {
            return $this;
        }

        $this->amount = $amount;

        if (Status::PENDING === $this->status) {
            $this->status = Status::SUCCEEDED;
        }

        return $this;
    }
}
