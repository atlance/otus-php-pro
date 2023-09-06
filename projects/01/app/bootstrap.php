<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require_once 'vendor/autoload.php';

(new Dotenv())->bootEnv(__DIR__ . \DIRECTORY_SEPARATOR . '.env');
