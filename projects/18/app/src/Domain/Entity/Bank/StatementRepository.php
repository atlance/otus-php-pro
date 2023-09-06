<?php

declare(strict_types=1);

namespace App\Domain\Entity\Bank;

use App\Domain\Entity\AbstractRepository;

/**
 * @extends AbstractRepository<Statement>
 *
 * @method Statement|null findOneBy(array $criteria);
 */
class StatementRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Statement::class);
    }

    /**
     * Emulating.
     *
     * @psalm-return Statement
     */
    public function getBy(string $email, string $startDate, string $endDate): Statement
    {
        return new Statement($email, $startDate, $endDate);
    }
}
