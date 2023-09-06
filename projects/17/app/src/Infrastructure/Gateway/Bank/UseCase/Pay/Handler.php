<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Pay;

use App\Application\UseCase\Payment\Pay\Contract\PayInterface;
use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Domain\VO\Money\Amount;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Handler implements PayInterface
{
    private const URL = '/payments/pay';
    private const METHOD = 'POST';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly Factory\Request\Contract\FactoryInterface $request,
        private readonly Factory\Response\Contract\FactoryResolverInterface $resolver,
    ) {
    }

    public function pay(PaymentInterface $payment, Amount $amount): PaymentInterface
    {
        $response = $this->client->request(self::METHOD, self::URL, $this->request->create($payment, $amount));

        return $this->resolver->resolve($response->getStatusCode())->create($response);
    }
}
