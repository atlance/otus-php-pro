<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Request;

use App\Domain\VO\Card\Contract\BankCardInterface;

final class Factory implements Contract\FactoryInterface
{
    public function create(BankCardInterface $card): array
    {
        return [
            'json' => [
                'number' => $card->getNumber()->getValue(),
                'expiry' => $card->getExpiry()->getValue(),
                'cvv' => $card->getCvv()->getValue(),
                'holder' => $card->getHolder()?->getValue(),
            ],
        ];
    }
}
