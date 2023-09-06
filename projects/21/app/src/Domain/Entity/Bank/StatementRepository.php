<?php

declare(strict_types=1);

namespace App\Domain\Entity\Bank;

use App\Domain\Command\UseCase\Bank\Statement\Create\Command;
use App\Domain\Entity\AbstractRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends AbstractRepository<Statement>
 *
 * @method Statement|null findOneBy(array $criteria, array $orderBy = null);
 */
final class StatementRepository extends AbstractRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Statement::class);
    }

    public function createIfNotExists(Command $command): Statement
    {
        $new = Statement::generation($command);

        $object = $this->findOneBy([
            'email' => $new->getEmail(),
            'startAt' => $new->getStartAt(),
            'endAt' => $new->getEndAt(),
        ]);

        if (null === $object) {
            $this->em->persist($new);

            return $new;
        }

        return $object;
    }
}
