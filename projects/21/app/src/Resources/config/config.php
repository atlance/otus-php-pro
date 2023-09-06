<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Database\Doctrine\Dbal\Type;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $dir = \dirname(__DIR__);

    $configurator->extension(
        'doctrine',
        [
            'dbal' => [
                'types' => [
                    Type\EmailType::NAME => Type\EmailType::class,
                ],
            ],
            'orm' => [
                'mappings' => [
                    'App\Domain\Entity' => [
                        'type' => 'attribute',
                        'dir' => \dirname(__DIR__, 2) . '/Domain/Entity',
                        'is_bundle' => false,
                        'prefix' => __NAMESPACE__ . '\Domain\Entity',
                        'alias' => __NAMESPACE__,
                    ],
                ],
            ],
        ]
    );

    $configurator->extension('framework', ['translator' => ['paths' => ["{$dir}/translations"]]]);
    $configurator->extension('framework', ['messenger' => ['routing' => [
        // Команда. Создать банковскую выписку.
        Domain\Command\UseCase\Bank\Statement\Create\Command::class => ['async'],
        // Событие. Банковская выписка создана.
        Domain\Event\UseCase\Bank\Statement\Created::class => ['async'],
        // Событие. Банковская выписка сгенерирована.
        Domain\Event\UseCase\Bank\Statement\Generated::class => ['async'],
    ]]]);
    $configurator->extension('twig', ['paths' => ["{$dir}/templates" => 'src']]);

    $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'services.yaml');
};
