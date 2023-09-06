<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

try {
    (new App\Client\App())->run();
} catch (Exception $e) {
    echo "{$e->getMessage()} - {$e->getTraceAsString()}";
}
