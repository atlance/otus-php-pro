<?php

declare(strict_types=1);

namespace App\Domain\Entity\Order;

use App\Domain\AbstractRepository;
use App\Domain\VO\Money;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\UuidV7;

/**
 * @extends AbstractRepository<Order>
 *
 * @method Order      get($id);
 * @method Order|null find($id);
 * @method Order|null findOneBy(array $criteria, array $orderBy = null);
 * @method Order[]    findAll();
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
 * @method Order[]    findByIds(array $ids);
 */
final class OrderRepository extends AbstractRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Order::class);
    }

    public function create(VO\Number $number, UuidV7 $paymentId, Money\Amount $amount): Order
    {
        $object = new Order($number, $paymentId, $amount);
        $this->em->persist($object);

        return $object;
    }
}
