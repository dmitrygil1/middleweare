<?php

declare(strict_types=1);

use App\Application\Validation\Authenticate\LoginValidation;
use App\Infrastructure\Middleware\ValidationMiddleware;

use App\Application\Validation\Authenticate\RegisterValidation;
use App\Domain\Controller\Authenticate\LoginController;
use App\Domain\Controller\Authenticate\LogoutController;
use App\Domain\Controller\Authenticate\RegisterController;
use App\Domain\Controller\DashboardController;
use App\Domain\Controller\HomeController;
use App\Infrastructure\Middleware\AuthenticatedMiddleware;
use App\Infrastructure\Middleware\StaticFileMiddleware;
use Slim\App;

return function (App $app): void {

    // Статика (скрипты/Стили)
    $app->add(StaticFileMiddleware::class);

    // Маршруты регистрации
    $app->get('/register', [RegisterController::class, 'render']);
    $app->post('/register', [RegisterController::class, 'handle'])
        ->add(new ValidationMiddleware(new RegisterValidation()));

    // Маршруты для входа
    $app->get('/login', [LoginController::class, 'render']);
    $app->post('/login', [LoginController::class, 'handle'])
        ->add(new ValidationMiddleware(new LoginValidation()));

    // Маршруты для аутентификации
    $app->get('/', HomeController::class);

    // Группа маршрутов для авторизованных пользователей
    $app->group('/dashboard', function () use ($app) {
        $app->get('/dashboard', DashboardController::class);
        $app->post('/logout', LogoutController::class);
    })->add(AuthenticatedMiddleware::class);

    // Обработчик ошибок
    $app->addErrorMiddleware(true, true, true);
};
