<?php

declare(strict_types=1);

namespace App\Domain\UseCase\Bank\Generate\Statement;

use App\Application\Validation\Constraint as App;
use App\Domain\Bus\Contract\Command\CommandInterface;
use App\Domain\Bus\Middleware\Contract\LockableInterface;
use App\Domain\Comparator\Comparison;
use App\Domain\Comparator\DateComparator;
use App\Domain\DataTransferObject;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\GroupSequence(['Command', 'compare_start_date', 'compare_end_date', 'compare_start_end_date'])]
// дата не может быть будущим.
#[App\Compare(
    a: 'startDate',
    b: new \DateTime(),
    comparator: new DateComparator(Comparison::LTE, 'Y-m-d'),
    groups: ['compare_start_date']
)]
// дата не может быть будущим.
#[App\Compare(
    a: 'endDate',
    b: new \DateTime(),
    comparator: new DateComparator(Comparison::LTE, 'Y-m-d'),
    groups: ['compare_end_date']
)]
// дата окончания должна быть больше даты начала.
#[App\Compare(
    a: 'endDate',
    b: 'startDate',
    comparator: new DateComparator(Comparison::GTE, 'Y-m-d'),
    groups: ['compare_start_end_date']
)]
final class Command extends DataTransferObject implements CommandInterface, LockableInterface
{
    private const LOCK_KEY_PATTERN = 'generate_bank_statement_%s_%s_%s';
    private const LOCK_TTL = 5;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\Email(message: 'validation.message.email')]
    public string $email;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\DateTime('Y-m-d')]
    public string $startDate;

    #[Assert\NotBlank(message: 'validation.message.not_null')]
    #[Assert\DateTime('Y-m-d')]
    public string $endDate;

    /** {@inheritdoc} */
    public function getKey(): string
    {
        return sprintf(self::LOCK_KEY_PATTERN, $this->email, $this->startDate, $this->endDate);
    }

    /** {@inheritdoc} */
    public function getTtl(): int
    {
        return self::LOCK_TTL;
    }
}
