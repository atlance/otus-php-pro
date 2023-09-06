<?php

declare(strict_types=1);

namespace App\Domain\Entity\Payment;

use App\Domain\AbstractRepository;
use App\Domain\Entity\Card\Card;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends AbstractRepository<Payment>
 *
 * @method Payment      get($id);
 * @method Payment|null find($id);
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null);
 * @method Payment[]    findAll();
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
 * @method Payment[]    findByIds(array $ids);
 */
final class PaymentRepository extends AbstractRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Payment::class);
    }

    public function withPendingByCriteria(array $criteria): ?Payment
    {
        return $this->findOneBy(array_merge($criteria, ['status' => Status::PENDING]));
    }

    public function create(Card $card): Payment
    {
        $object = new Payment($card);
        $this->em->persist($object);

        return $object;
    }
}
