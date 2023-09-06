<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Bank\UseCase\Create;

use App\Application\UseCase\Payment\Pay\Contract\PaymentFactoryInterface;
use App\Application\UseCase\Payment\Pay\Contract\PaymentInterface;
use App\Domain\VO\Card\Contract\BankCardInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Handler implements PaymentFactoryInterface
{
    private const URL = '/payments/create';
    private const METHOD = 'POST';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly Factory\Request\Contract\FactoryInterface $request,
        private readonly Factory\Response\Contract\FactoryResolverInterface $resolver,
    ) {
    }

    public function create(BankCardInterface $card): PaymentInterface
    {
        $response = $this->client->request(self::METHOD, self::URL, $this->request->create($card));

        return $this->resolver->resolve($response->getStatusCode())->create($response);
    }
}
