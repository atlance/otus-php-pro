<?php

declare(strict_types=1);

namespace App\Tests\Functional\Acceptance\Infrastructure\Http\Controller\Payment\Pay;

use App\Domain\Entity\Order\VO\NumberGenerator;
use App\Domain\VO\Card\Expiry;
use App\Fixtures\Order\Fixture;
use App\Infrastructure\Http\Controller\Payment\Pay\Controller;
use App\Tests\Functional\Acceptance\TestCase;
use Symfony\Component\HttpFoundation\Response;

/** @see Controller */
class Code400ControllerTest extends TestCase
{
    /**
     * @dataProvider dataset
     *
     * @param array{number:string,cvv:string,expiry:string,order_number:string,amount:string} $content
     */
    public function test(array $content): void
    {
        $this->requester()->post(Controller::class, content: $content, expectCode: Response::HTTP_BAD_REQUEST);
    }

    public static function dataset(): array
    {
        return [
            // Not valid card number -----------------------------------------------------------------------------------
            'number - luhn' => [Request\Fixture::data(['number' => '4506347049583144'])],
            'number - str length' => [Request\Fixture::data(['number' => '450634704958314'])],
            'number - not number' => [Request\Fixture::data(['number' => 'a450634704958314'])],
            'number - required' => [Request\Fixture::data(['number' => null])],
            'number - exists in database' => [Request\Fixture::data(['number' => Fixture::ORDER_FIXTURE_UNIQ_NUMBER])],
            // Not valid card cvv --------------------------------------------------------------------------------------
            'cvv - str length' => [Request\Fixture::data(['cvv' => '12'])],
            'cvv - not number' => [Request\Fixture::data(['cvv' => 'a12'])],
            'cvv - required' => [Request\Fixture::data(['cvv' => null])],
            // Not valid card expiry -----------------------------------------------------------------------------------
            'expiry - not format m/y' => [Request\Fixture::data(['expiry' => '13/23'])],
            'expiry - expired' => [Request\Fixture::data(['expiry' => (string) Expiry::fromDateTime(new \DateTime('-1 month'))])],
            'expiry - required' => [Request\Fixture::data(['expiry' => null])],
            // Not valid card holder -----------------------------------------------------------------------------------
            'holder - only chars' => [Request\Fixture::data(['holder' => 'GERMAN GREF1'])],
            'holder - 2 spaces' => [Request\Fixture::data(['holder' => 'GERMAN  GREF'])],
            'holder - only latin chars' => [Request\Fixture::data(['holder' => 'ВАСЯ ПУПКИН'])],
            // Not valid order number ----------------------------------------------------------------------------------
            'order number - out range' => [Request\Fixture::data(['order_number' => NumberGenerator::generate(17, 17)])],
            'order number - required' => [Request\Fixture::data(['order_number' => null])],
            // Not valid order amount ----------------------------------------------------------------------------------
            'amount - not number' => [Request\Fixture::data(['amount' => 'a120,35'])],
            'amount - not positive number' => [Request\Fixture::data(['amount' => '-120,35'])],
            'amount - required' => [Request\Fixture::data(['amount' => null])],
        ];
    }
}
