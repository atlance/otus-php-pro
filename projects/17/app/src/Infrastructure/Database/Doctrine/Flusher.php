<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine;

use App\Domain\Contract\FlusherInterface;
use Doctrine\ORM\EntityManagerInterface;

final class Flusher implements FlusherInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function flush(bool $deferred = false): void
    {
        if (true === $deferred) {
            $connection = $this->em->getConnection();
            $connection->beginTransaction(); // suspend auto-commit
            try {
                // @see https://www.postgresql.org/docs/current/sql-set-constraints.html
                $connection->executeQuery('SET CONSTRAINTS ALL DEFERRED');

                $this->em->flush();

                $connection->commit();
            } catch (\Exception $e) {
                $connection->rollBack();

                throw $e;
            }

            return;
        }

        $this->em->flush();
    }
}
