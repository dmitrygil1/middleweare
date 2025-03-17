<?php
declare(strict_types=1);

use App\Application\Service\AuthenticateService;
use App\Application\Service\PasswordHashService;
use App\Application\Service\RegistrationService;
use App\Application\Service\SessionService;
use App\Domain\Entity\User\UserRepository;
use App\Domain\Entity\User\UserRepositoryInterface;
use App\Domain\Service\AuthenticateServiceInterface;
use App\Domain\Service\PasswordHashServiceInterface;
use App\Domain\Service\RegistrationServiceInterface;
use App\Infrastructure\Service\SessionServiceInterface;
use App\Infrastructure\Middleware\StaticFileMiddleware;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Slim\Psr7\Factory\StreamFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Domain\Controller\Authenticate\RegisterController;

use function DI\autowire;

$slimConfig           = require 'config/slim.php';
$doctrineConfig       = require 'config/doctrine.php';
$entityManagerFactory = require 'entity-manager.php';

try {
    $containerBuilder = new ContainerBuilder();
    $containerBuilder->useAutowiring(true);
    $container = $containerBuilder->build();
} catch (\Exception $e) {
    error_log('Container build failed: ' . $e->getMessage());

    echo 'There was an error setting up the application. Please try again later.';
    exit;
}

$configs = [
    'slim' => $slimConfig,
    'doctrine' => $doctrineConfig,
];

$container->set('configs', $configs);
$container->set(StreamFactoryInterface::class, new StreamFactory);
$container->set(EntityManagerInterface::class, $entityManagerFactory($container->get('configs')['doctrine']));

$container->set(UserRepositoryInterface::class, autowire(UserRepository::class));
$container->set(SessionServiceInterface::class, autowire(SessionService::class));
$container->set(PasswordHashServiceInterface::class, autowire(PasswordHashService::class));
$container->set(AuthenticateServiceInterface::class, autowire(AuthenticateService::class));
$container->set(RegistrationServiceInterface::class, autowire(RegistrationService::class));
$container->set(StaticFileMiddleware::class, autowire(StaticFileMiddleware::class));

$container->set(ValidatorInterface::class, function () {
    return Validation::createValidator();
});

// Регистрация контроллера
$container->set(RegisterController::class, autowire(RegisterController::class));

return $container;
