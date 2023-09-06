<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $dir = \dirname(__DIR__);

    $configurator->extension('framework', ['translator' => ['paths' => ["{$dir}/translations"]]]);
    $configurator->extension('twig', ['paths' => ["{$dir}/templates" => 'src']]);

    $configurator->import(__DIR__ . \DIRECTORY_SEPARATOR . 'services.yaml');
};
