<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\EventStorage\Presentation\Controller\Event\FindOne\Relevant;

use App\EventStorage\Domain\Entity\Event\Event;
use App\EventStorage\Presentation\Controller\Event\FindOne\Relevant\Controller;
use App\Tests\Acceptance\EventStorage\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV4;

/** @see Controller */
class ControllerTest extends TestCase
{
    /** @dataProvider datasets */
    public function test(array $content, int $expectCode): void
    {
        $this->clearStorage();
        $this->loadFixtures();

        $response = $this->requester()
            ->get(routeClass: Controller::class, routeParams: $content, expectCode: $expectCode);

        /** @var Event $object */
        $object = $this->hydrator()->hydrate($response->content, Event::class);

        self::assertEquals('3900b029-98f9-4e19-aec0-cf2f5d5bda83', $object->getId());
    }

    private function clearStorage(): void
    {
        $this->repository()->clear();
    }

    private function loadFixtures(): void
    {
        foreach ($this->fixtures() as $fixture) {
            $this->repository()->save($fixture);
        }
    }

    private function fixtures(): array
    {
        return [
            new Event(new UuidV4('3900b029-98f9-4e19-aec0-cf2f5d5bda81'), ['param1' => 1], 1000),
            new Event(new UuidV4('3900b029-98f9-4e19-aec0-cf2f5d5bda82'), ['param1' => 2, 'param2' => 2], 2000),
            new Event(new UuidV4('3900b029-98f9-4e19-aec0-cf2f5d5bda83'), ['param1' => 1, 'param2' => 2], 3000),
        ];
    }

    public static function datasets(): array
    {
        return [
            [['conditions' => ['param1' => 1, 'param2' => 2]], Response::HTTP_OK],
        ];
    }
}
