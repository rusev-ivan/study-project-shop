<?php

use Laminas\Diactoros\ServerRequestFactory;
use Shop\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$kernel = new Kernel(__DIR__ . '/../config/di.php', __DIR__ . '/../config/routes.php');
$kernel->handle(ServerRequestFactory::fromGlobals());