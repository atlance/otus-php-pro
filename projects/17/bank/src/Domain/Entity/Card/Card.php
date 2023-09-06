<?php

declare(strict_types=1);

namespace App\Domain\Entity\Card;

use App\Domain\Entity\Card\Contract\BankCardInterface;
use App\Infrastructure\Database\Doctrine\Dbal\Type\ColumnType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME, options: ['comment' => 'Банковские карты.'])]
class Card implements BankCardInterface
{
    final public const TABLE_NAME = 'banks_cards';

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: ColumnType::UUID, options: ['comment' => 'Идентификатор.'])]
    private UuidV7 $id;

    #[ORM\Column(
        name: 'number',
        type: ColumnType::BANK_CARD_NUMBER,
        length: 16,
        unique: true,
        options: ['comment' => 'Номер карты.']
    )]
    private VO\Number $number;

    #[ORM\Column(
        name: 'expiration_at',
        type: ColumnType::BANK_CARD_EXPIRY,
        options: ['comment' => 'Месяц/год окончания действия карты']
    )]
    private VO\Expiry $expiry;

    #[ORM\Column(
        name: 'cvv',
        type: ColumnType::BANK_CARD_CVV,
        length: 3,
        options: ['comment' => 'Код с обратной стороны карты']
    )]
    private VO\Cvv $cvv;

    #[ORM\Column(
        name: 'holder',
        type: ColumnType::BANK_CARD_HOLDER,
        nullable: true,
        options: ['comment' => 'Владелец карты, имя и фамилия латиницей, может также содержать дефис']
    )]
    private ?VO\Holder $holder;

    public function __construct(
        VO\Number $number,
        VO\Expiry $expiry,
        VO\Cvv $cvv,
        ?VO\Holder $holder = null,
        UuidV7 $id = new UuidV7(),
    ) {
        $this->number = $number;
        $this->cvv = $cvv;
        $this->expiry = $expiry;
        $this->holder = $holder;
        $this->id = $id;
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getNumber(): VO\Number
    {
        return $this->number;
    }

    public function getExpiry(): VO\Expiry
    {
        return $this->expiry;
    }

    public function getCvv(): VO\Cvv
    {
        return $this->cvv;
    }

    public function getHolder(): ?VO\Holder
    {
        return $this->holder;
    }
}
