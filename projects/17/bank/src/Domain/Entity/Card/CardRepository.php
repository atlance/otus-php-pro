<?php

declare(strict_types=1);

namespace App\Domain\Entity\Card;

use App\Domain\AbstractRepository;
use App\Domain\Entity\Card\Contract\BankCardInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends AbstractRepository<Card>
 *
 * @method Card      get($id);
 * @method Card|null find($id);
 * @method Card|null findOneBy(array $criteria, array $orderBy = null);
 * @method Card[]    findAll();
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
 * @method Card[]    findByIds(array $ids);
 */
final class CardRepository extends AbstractRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Card::class);
    }

    public function create(BankCardInterface $card): Card
    {
        $object = new Card(
            number: $card->getNumber(),
            expiry: $card->getExpiry(),
            cvv: $card->getCvv(),
            holder: $card->getHolder()
        );

        $this->em->persist($object);

        return $object;
    }
}
