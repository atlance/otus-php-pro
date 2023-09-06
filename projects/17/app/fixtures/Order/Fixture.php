<?php

declare(strict_types=1);

namespace App\Fixtures\Order;

use App\Domain\Entity\Order\OrderRepository;
use App\Domain\Entity\Order\VO;
use App\Domain\VO\Money;
use Doctrine\Bundle\FixturesBundle\Fixture as BaseFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\UuidV7;

class Fixture extends BaseFixture
{
    public const ORDER_FIXTURE_UNIQ_NUMBER = 'fixture-number-1';

    public function __construct(private readonly OrderRepository $repository)
    {
    }

    /** {@inheritdoc} */
    public function load(ObjectManager $manager): void
    {
        $number = new VO\Number(self::ORDER_FIXTURE_UNIQ_NUMBER);
        $object = $this->repository->findOneBy(['number' => $number]);

        if (null === $object) {
            $object = $this->repository->create($number, new UuidV7(), new Money\Amount('1250.35'));

            $manager->flush();
        }

        $this->addReference(self::ORDER_FIXTURE_UNIQ_NUMBER, $object);
    }
}
