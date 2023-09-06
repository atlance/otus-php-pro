<?php

declare(strict_types=1);

namespace App\Domain\VO\Card\Contract;

use App\Domain\VO\Card;

interface BankCardInterface
{
    /** Номер банковской карты. */
    public function getNumber(): Card\Number;

    /** Месяц и год истечения срока действия карты. */
    public function getExpiry(): Card\Expiry;

    /** Код CVV, печатается на обратной стороне карты. */
    public function getCvv(): Card\Cvv;

    /** Имя(и фамилия) держателя карты. */
    public function getHolder(): ?Card\Holder;
}
