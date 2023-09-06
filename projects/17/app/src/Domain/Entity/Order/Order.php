<?php

declare(strict_types=1);

namespace App\Domain\Entity\Order;

use App\Domain\VO\Money;
use App\Infrastructure\Database\Doctrine\Dbal\Type\ColumnType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME, options: ['comment' => 'Заказы.'])]
class Order
{
    final public const TABLE_NAME = 'orders';

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: ColumnType::UUID, options: ['comment' => 'Идентификатор.'])]
    private UuidV7 $id;

    #[ORM\Column(
        name: 'number',
        type: ColumnType::ORDER_NUMBER,
        length: VO\Number::MAX_LENGTH,
        unique: true,
        options: ['comment' => 'Номер заказа.']
    )]
    private VO\Number $number;

    #[ORM\Column(
        name: 'payment_id',
        type: ColumnType::UUID,
        unique: true,
        options: ['comment' => 'Идентификатор платежа.']
    )]
    private UuidV7 $paymentId;

    #[ORM\Column(name: 'sum', type: ColumnType::MONEY_AMOUNT, options: ['comment' => 'Сумма платежа.'])]
    private Money\Amount $sum;

    public function __construct(VO\Number $number, UuidV7 $paymentId, Money\Amount $sum, UuidV7 $id = new UuidV7())
    {
        $this->number = $number;
        $this->paymentId = $paymentId;
        $this->sum = $sum;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getNumber(): VO\Number
    {
        return $this->number;
    }

    public function getPaymentId(): UuidV7
    {
        return $this->paymentId;
    }

    public function getSum(): Money\Amount
    {
        return $this->sum;
    }
}
