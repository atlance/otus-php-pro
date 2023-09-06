<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Gateway\Bank\UseCase\Create;

use App\Application\UseCase\Payment\Pay\Contract\PaymentFactoryInterface;
use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Domain\VO\Card\Contract\BankCardInterface;
use App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Response\Dto;
use Symfony\Component\Uid\UuidV7;

final class Handler implements PaymentFactoryInterface
{
    public function create(BankCardInterface $card): PaymentInterface
    {
        return Dto\Ok::fromHashtable([
            'id' => (new UuidV7())->toRfc4122(),
            'status' => 'pending',
            'amount' => null,
            'created_at' => (new \DateTime())->format(\DateTime::ATOM),
        ]);
    }
}
