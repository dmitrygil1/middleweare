<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Domain\Service\AuthenticateServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Response;
readonly class AuthenticatedMiddleware implements MiddlewareInterface
{
    public function __construct(
        private AuthenticateServiceInterface $authenticateService,
    ) {}

    /**
     * Process the incoming request to ensure the user is authenticated.
     *
     * @param  ServerRequestInterface  $request  The HTTP request.
     * @param  RequestHandlerInterface  $handler  The request handler.
     * @return ResponseInterface The HTTP response.
     *
     * @throws HttpUnauthorizedException If the user is not authenticated.
     */
    #[Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $username = $this->authenticateService->getAuthenticatedUsername();
        if (is_null($username)) {

            return (new Response())
                ->withHeader('Location', '/login?error=unauthorized')
                ->withStatus(302);
        }

        $request = $request->withAttribute('username', $username);

        return $handler->handle($request);
    }

}
