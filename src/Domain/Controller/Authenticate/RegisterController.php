<?php

declare(strict_types=1);

namespace App\Domain\Controller\Authenticate;

use App\Application\DTO\Authenticate\LoginRequestDTO;
use App\Domain\Controller\Controller;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Domain\Service\RegistrationServiceInterface;
use App\Domain\DomainException\Registration\UsernameAlreadyTakenException;

class RegisterController extends Controller
{
    public function __construct(
        private readonly RegistrationServiceInterface $registrationService,
    ) {}

    public function render(Request $request, Response $response): ResponseInterface
    {
        return $this->view($request, $response, 'register.html.twig');
    }

    public function handle(Request $request, Response $response): ResponseInterface
    {
        $dto = LoginRequestDTO::fromArray($request->getParsedBody());

        try {
            $this->registrationService->register($dto->getUsername(), $dto->getPassword());

            return $this->json($response, [
                'status' => 'ok',
            ], self::HTTP_STATUS_CREATED);
        } catch (UsernameAlreadyTakenException) {
            return $this->json($response, [
                'errors' => [
                    'username' => 'Логин уже занят.',
                ],
            ], self::HTTP_STATUS_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json($response,
                (array)$e->getMessage(),
            );
        }
    }
}

