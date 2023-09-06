<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Application extends Kernel
{
    use MicroKernelTrait;

    private function configureContainer(
        ContainerConfigurator $container,
        LoaderInterface $loader,
        ContainerBuilder $builder
    ): void {
        $dir = $this->getProjectDir();
        // Global configuration.
        $this->configureGlobalContainer($container, $loader, $builder, "{$dir}/config");
        // Core configuration.
        $container->import("{$dir}/core/Resources/config/config.php", null, true);
        // App configuration.
        $container->import("{$dir}/src/**/Resources/config/config.php", null, true);
    }

    private function configureGlobalContainer(
        ContainerConfigurator $container,
        LoaderInterface $loader,
        ContainerBuilder $builder,
        string $configDir
    ): void {
        $container->import($configDir . '/{packages}/*.yaml');
        $container->import($configDir . '/{packages}/' . $this->environment . '/*.yaml');

        if (is_file($configDir . '/services.yaml')) {
            $container->import($configDir . '/services.yaml');
            $container->import($configDir . '/{services}_' . $this->environment . '.yaml');
        }
    }

    private function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import("{$this->getProjectDir()}/**/Resources/config/routes.yaml", null, true);
    }
}
