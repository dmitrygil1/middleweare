<?php

declare(strict_types=1);

namespace App\Domain\Controller\Authenticate;

use App\Domain\Controller\Controller;
use App\Domain\Service\AuthenticateServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LogoutController extends Controller
{
    public function __construct(
        private readonly AuthenticateServiceInterface $authenticateService,
    ) {}

    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $this->authenticateService->logout();

        return $this->json($response, [
            'status' => 'ok',
        ]);
    }
}
