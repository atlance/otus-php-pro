<?php

declare(strict_types=1);

namespace App\Tests\Utils\Requester;

use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

final class Requester extends Assert
{
    use WebTestAssertionsTrait;

    private readonly JsonEncoder $encoder;

    public function __construct(private readonly KernelBrowser $client, private readonly RouterInterface $router)
    {
        $this->encoder = new JsonEncoder();
    }

    public function get(
        string $routeClass,
        array $routeParams = [],
        int $expectCode = Response::HTTP_OK,
        array $headers = []
    ): Dto\Response {
        $path = $this->getPath($routeClass, $routeParams);
        $this->client->request('GET', $path, [], [], $this->headers($headers));
        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    public function post(
        string $routeClass,
        array $routeParams = [],
        array $content = [],
        array $files = [],
        int $expectCode = Response::HTTP_OK,
        array $headers = [],
    ): Dto\Response {
        $path = $this->getPath($routeClass, $routeParams);
        $content = $this->encoder->encode($content, JsonEncoder::FORMAT);

        $this->client->request('POST', $path, [], $files, $this->headers($headers), $content);
        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    public function delete(
        string $routeClass,
        array $routeParams = [],
        int $expectCode = Response::HTTP_OK,
        array $headers = [],
    ): Dto\Response {
        $path = $this->getPath($routeClass, $routeParams);
        $this->client->request('DELETE', $path, [], [], $this->headers($headers));

        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    public function getClient(): KernelBrowser
    {
        return $this->client;
    }

    /** @param class-string $className */
    private function getPath(string $className, array $params = []): string
    {
        return $this->router->generate($className, $params, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    private function headers(array $headers = [], bool $json = true): array
    {
        if ($json) {
            $headers['CONTENT_TYPE'] = 'application/json';
            $headers['HTTP_ACCEPT'] = 'application/json';
        }

        return $headers;
    }

    private function response(): Dto\Response
    {
        $response = $this->client->getResponse();

        $data = [
            'code' => $response->getStatusCode(),
            'type' => $response->headers->get('content_type'),
            'headers' => $response->headers,
        ];

        $content = $response->getContent();
        if (\is_string($content) && 'application/json' === $data['type']) {
            /** @var mixed */
            $content = $this->encoder->decode($content, JsonEncoder::FORMAT);

            if (\is_array($content) && \array_key_exists('data', $content) && \is_array($content['data'])) {
                /** @var mixed $content */
                $content = $content['data'];
            }
        }

        $data['content'] = $content;

        return new Dto\Response($data);
    }

    private function assertResponseStatusCode(Dto\Response $response, int $expectCode = Response::HTTP_OK): void
    {
        self::assertTrue($expectCode === $response->code, "expected code {$expectCode} !== {$response->code}");
    }
}
