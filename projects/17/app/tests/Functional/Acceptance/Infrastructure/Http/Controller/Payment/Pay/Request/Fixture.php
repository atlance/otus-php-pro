<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\Payment\Pay\Request;

use App\Domain\Entity\Order\VO\Number;
use App\Domain\VO\Card\Expiry;

final class Fixture
{
    /** @return array{number:string,cvv:string,expiry:string,order_number:string,amount:string} */
    public static function data(array $override = []): array
    {
        // @phpstan-ignore-next-line
        return array_merge([
            'number' => '4506347049583145',
            'cvv' => '123',
            'expiry' => (string) Expiry::fromDateTime(new \DateTime()),
            'holder' => 'GERMAN GREF',
            'order_number' => (string) new Number(),
            'amount' => '120,35',
        ], $override);
    }
}
