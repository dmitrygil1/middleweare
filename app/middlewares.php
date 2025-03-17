<?php

declare(strict_types=1);

use App\Infrastructure\Middleware\JsonBodyParserMiddleware;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (App $app): void {

    // Получаем настройки контейнера
    $settings = $app->getContainer()->get('configs')['slim'];
    $app->addRoutingMiddleware();

    // Настройка отображаемых ошибок
    $app->addErrorMiddleware(
        $settings['errors']['display_error_details'],
        $settings['errors']['log_errors'],
        $settings['errors']['log_error_details']
    );

    // Цепляем twig
    $app->add(TwigMiddleware::create($app, Twig::create(ROOT_PATH . '/assets/templates', ['cache' => false])));

    // Утила для фронта
    $app->add(JsonBodyParserMiddleware::class);
};
