<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $env = $configurator->env();

    $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'services.yaml');

    if (null !== $env) {
        $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . '{services}_' . $env . '.yaml', ignoreErrors: true);
    }
};
