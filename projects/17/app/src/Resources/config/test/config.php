<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'services.yaml');
};
