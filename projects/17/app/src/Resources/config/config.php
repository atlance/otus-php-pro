<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Database\Doctrine\Dbal;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->extension(
        'doctrine',
        [
            'dbal' => [
                'types' => [
                    // Деньги. Количество.
                    Dbal\Type\ColumnType::MONEY_AMOUNT => Dbal\Type\Money\AmountType::class,
                    // Заказ. Номер.
                    Dbal\Type\ColumnType::ORDER_NUMBER => Dbal\Type\Order\NumberType::class,
                ],
            ],
            'orm' => [
                'mappings' => [
                    'App\Domain\Entity' => [
                        'type' => 'attribute',
                        'dir' => \dirname(__DIR__, 2) . '/Domain/Entity',
                        'is_bundle' => false,
                        'prefix' => __NAMESPACE__ . '\Domain\Entity',
                        'alias' => 'App',
                    ],
                ],
            ],
        ]
    );
    $configurator->extension('framework', ['translator' => ['paths' => [\dirname(__DIR__) . '/translations']]]);

    $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'services.yaml');
};
