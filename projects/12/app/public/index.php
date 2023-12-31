<?php

declare(strict_types=1);

use App\Application;

if (!is_file(dirname(__DIR__) . '/vendor/autoload_runtime.php')) {
    throw new LogicException('Symfony Runtime is missing. Try running "composer require symfony/runtime".');
}

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Application($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
