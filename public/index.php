<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

session_start();

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH.'/vendor/autoload.php';
$container = require ROOT_PATH.'/app/dependencies.php';

$app = AppFactory::createFromContainer($container);

$middlewares = require ROOT_PATH.'/app/middlewares.php';
$middlewares($app);

$routes = require ROOT_PATH.'/app/routes.php';
$routes($app, $container);

$app->run();
