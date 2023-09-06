<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use App\Core\Presentation\Controller\AbstractController;
use App\Exceptions\UnexpectedClassException;
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

    private JsonEncoder $json;

    public function __construct(private readonly KernelBrowser $client, private readonly RouterInterface $router)
    {
        $this->json = new JsonEncoder();
    }

    public function get(
        string $routeClass,
        array $routeParams = [],
        int $expectCode = Response::HTTP_OK
    ): DtoResponse {
        $path = $this->getPath($routeClass, $routeParams);
        $this->client->request('GET', $path, [], [], $this->headers());
        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    public function post(
        string $routeClass,
        array $routeParams = [],
        array $content = [],
        array $files = [],
        int $expectCode = Response::HTTP_OK
    ): DtoResponse {
        $path = $this->getPath($routeClass, $routeParams);
        $content = $this->json->encode($content, $this->json::FORMAT);

        $this->client->request('POST', $path, [], $files, $this->headers(), $content);
        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    public function delete(
        string $routeClass,
        array $routeParams = [],
        int $expectCode = Response::HTTP_OK
    ): DtoResponse {
        $path = $this->getPath($routeClass, $routeParams);
        $this->client->request('DELETE', $path, [], [], $this->headers());

        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    public function getClient(): KernelBrowser
    {
        return $this->client;
    }

    /**
     * @param class-string $className
     */
    private function getPath(string $className, array $params = []): string
    {
        if (!class_exists($className) || !is_subclass_of($className, AbstractController::class)) {
            throw new UnexpectedClassException(AbstractController::class);
        }

        return $this->router->generate($className, $params, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    private function headers(bool $json = true): array
    {
        $headers = [];

        if ($json) {
            $headers['CONTENT_TYPE'] = 'application/json';
            $headers['HTTP_ACCEPT'] = 'application/json';
        }

        return $headers;
    }

    private function response(): DtoResponse
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
            $content = $this->json->decode($content, $this->json::FORMAT);

            if (\is_array($content) && \array_key_exists('data', $content) && \is_array($content['data'])) {
                /** @var mixed */
                $content = $content['data'];
            }
        }

        $data['content'] = $content;

        return new DtoResponse($data);
    }

    private function assertResponseStatusCode(DtoResponse $response, int $expectCode = Response::HTTP_OK): void
    {
        self::assertTrue($expectCode === $response->code, "expected code {$expectCode} !== {$response->code}");
    }
}
