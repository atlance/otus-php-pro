<?php

declare(strict_types=1);

namespace App\Domain\Command\UseCase\Bank\Statement\Create;

use App\Application\Validation\Constraint as App;
use App\Domain\Bus\Contract\Command\CommandInterface;
use App\Domain\Bus\Middleware\Contract\LockableInterface;
use App\Domain\Comparator\Comparison;
use App\Domain\Comparator\DateComparator;
use App\Domain\DataTransferObject;
use App\Domain\Entity\Bank\Statement;
use App\Domain\Entity\VO;
use DateTime;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\GroupSequence(['Command', 'compare_start_date', 'compare_end_date', 'compare_start_end_date', 'is_exist'])]
// Запись уже существует.
#[App\Criteria(
    table: Statement::TABLE_NAME,
    columns: ['email', 'start_at', 'end_at'],
    properties: ['email', 'startAt', 'endAt'],
    isExists: false,
    groups: ['is_exist']
)]
// дата не может быть будущим.
#[App\Compare(
    a: 'startAt',
    b: new DateTime(),
    comparator: new DateComparator(Comparison::LTE, 'Y-m-d'),
    groups: ['compare_start_date']
)]
// дата не может быть будущим.
#[App\Compare(
    a: 'endAt',
    b: new DateTime(),
    comparator: new DateComparator(Comparison::LTE, 'Y-m-d'),
    groups: ['compare_end_date']
)]
// дата окончания должна быть больше даты начала.
#[App\Compare(
    a: 'endAt',
    b: 'startAt',
    comparator: new DateComparator(Comparison::GTE, 'Y-m-d'),
    groups: ['compare_start_end_date']
)]
final class Command extends DataTransferObject implements CommandInterface, LockableInterface
{
    private const LOCK_KEY_PATTERN = 'generate_bank_statement_%s_%s_%s';
    private const LOCK_TTL = 5;

    #[Ignore]
    public UuidV7 $id;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\Email(message: 'validation.message.email')]
    #[Assert\Regex(VO\Email::PATTERN, message: 'validation.message.email')]
    #[OA\Property(example: 'sample@mail.mail')]
    public string $email;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\DateTime('Y-m-d')]
    #[OA\Property(example: '2023-06-12')]
    public string $startAt;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\DateTime('Y-m-d')]
    #[OA\Property(example: '2023-06-15')]
    public string $endAt;

    public function __construct(UuidV7 $id = new UuidV7())
    {
        $this->id = $id;
    }

    #[Ignore]
    public function getId(): UuidV7
    {
        return $this->id;
    }

    #[Ignore]
    public function getKey(): string
    {
        return sprintf(self::LOCK_KEY_PATTERN, $this->email, $this->startAt, $this->endAt);
    }

    #[Ignore]
    public function getTtl(): int
    {
        return self::LOCK_TTL;
    }
}
