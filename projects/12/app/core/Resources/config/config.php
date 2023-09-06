<?php

declare(strict_types=1);

namespace App\Core;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    if (\extension_loaded('memcached')) {
        $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'memcached.yaml');
    }

    if (\extension_loaded('redis')) {
        $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'redis.yaml');
    }

    $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'services.yaml');
    $configurator->import(
        __DIR__ . \DIRECTORY_SEPARATOR . '{services}_' . $configurator->env() . '.yaml',
        ignoreErrors: true
    );
};
