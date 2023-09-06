<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create\Factory\Request\Contract;

use App\Domain\VO\Card\Contract\BankCardInterface;

interface FactoryInterface
{
    public function create(BankCardInterface $card): array;
}
