<?php

declare(strict_types=1);

namespace App\Domain\Entity\Card\Contract;

use App\Domain\Entity\Card\VO;

interface BankCardInterface
{
    /** Номер банковской карты. */
    public function getNumber(): VO\Number;

    /** Месяц и год истечения срока действия карты. */
    public function getExpiry(): VO\Expiry;

    /** Код CVV, печатается на обратной стороне карты. */
    public function getCvv(): VO\Cvv;

    /** Имя(и фамилия) держателя карты. */
    public function getHolder(): ?VO\Holder;
}
