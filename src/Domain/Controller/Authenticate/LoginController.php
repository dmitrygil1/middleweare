<?php

declare(strict_types=1);

namespace App\Domain\Controller\Authenticate;

use App\Application\DTO\Authenticate\LoginRequestDTO;
use App\Domain\Controller\Controller;
use App\Domain\DomainException\Authenticate\UnauthenticatedException;
use App\Domain\Service\AuthenticateServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthenticateServiceInterface $authenticateService,
    ) {}

    public function render(Request $request, Response $response): ResponseInterface
    {
        // Проверяем, авторизован ли пользователь
        $username = $this->authenticateService->getAuthenticatedUsername();

        // Если пользователь уже авторизован, перенаправляем его на главную страницу
        if ($username) {
            return $response->withHeader('Location', '/dashboard')
                ->withStatus(302);
        }

        // Если не авторизован, показываем страницу входа
        return $this->view($request, $response, 'login.html.twig');
    }

    public function handle(Request $request, Response $response): ResponseInterface
    {
        $dto = LoginRequestDTO::fromArray($request->getParsedBody());

        try {
            $this->authenticateService->authenticate($dto->getUsername(), $dto->getPassword());

            // После успешной авторизации, перенаправляем на страницу dashboard
            return $response->withHeader('Location', '/dashboard')
                ->withStatus(302);
        } catch (UnauthenticatedException) {
            // Возвращаем ошибку авторизации
            return $this->json($response, [
                'status' => 'unauthorized',
            ], self::HTTP_STATUS_UNAUTHORIZED);
        }
    }
}
