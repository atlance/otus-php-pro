<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap.php';

(new App\Controller())(Symfony\Component\HttpFoundation\Request::createFromGlobals())->send();
