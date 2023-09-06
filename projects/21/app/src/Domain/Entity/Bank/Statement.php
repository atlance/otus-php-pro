<?php

declare(strict_types=1);

namespace App\Domain\Entity\Bank;

use App\Domain\Command\UseCase\Bank\Statement\Create\Command;
use App\Domain\Entity\VO;
use App\Infrastructure\Database\Doctrine\Dbal\Type\ColumnType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;

#[ORM\Entity]
#[ORM\Table(name: self::TABLE_NAME, options: ['comment' => 'Банковские выписки.'])]
#[ORM\UniqueConstraint(columns: ['email', 'start_at', 'end_at'])]
class Statement
{
    final public const TABLE_NAME = 'banks_statements';

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: ColumnType::UUID, options: ['comment' => 'Идентификатор.'])]
    private UuidV7 $id;

    #[ORM\Column(name: 'email', type: ColumnType::EMAIL, options: ['comment' => 'Адрес электронной почты.'])]
    private VO\Email $email;

    #[ORM\Column(name: 'start_at', type: ColumnType::DATE_MUTABLE, options: ['comment' => 'Дата начала.'])]
    private DateTime $startAt;

    #[ORM\Column(name: 'end_at', type: ColumnType::DATE_MUTABLE, options: ['comment' => 'Дата окончания.'])]
    private DateTime $endAt;

    #[ORM\Column(
        name: 'status',
        enumType: Status::class,
        options: ['comment' => 'Статус выписки.', 'default' => Status::GENERATION]
    )]
    private Status $status;

    #[ORM\Column(
        name: 'created_at',
        type: ColumnType::DATETIME_IMMUTABLE,
        options: ['comment' => 'Дата и время создания.', 'default' => 'CURRENT_TIMESTAMP']
    )]
    private readonly \DateTimeImmutable $createdAt;

    public function __construct(
        VO\Email $email,
        DateTime $startAt,
        DateTime $endAt,
        UuidV7 $id = new UuidV7(),
        Status $status = Status::GENERATION,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
    ) {
        $this->email = $email;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getEmail(): VO\Email
    {
        return $this->email;
    }

    public function getStartAt(): DateTime
    {
        return $this->startAt;
    }

    public function getEndAt(): DateTime
    {
        return $this->endAt;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function toGeneratedStatus(): self
    {
        $this->status = Status::GENERATED;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public static function generation(Command $command): self
    {
        return new self(
            email: new VO\Email($command->email),
            startAt: new DateTime($command->startAt),
            endAt: new DateTime($command->endAt),
            id: $command->getId()
        );
    }
}
