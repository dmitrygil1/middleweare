<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Application\Validation\HasValidation;
use App\Domain\Controller\Controller;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Symfony\Component\Validator\Exception\ValidationFailedException;

readonly class ValidationMiddleware implements MiddlewareInterface
{
    public function __construct(private HasValidation $validation) {}

    #[Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $this->validation->validate((array) $request->getParsedBody());

            return $handler->handle($request);
        } catch (ValidationFailedException $e) {
            $response = new Response();
            $errors = [];

            foreach ($e->getViolations() as $violation) {
                // Убираем квадратные скобки через функцию Symfony
                $propertyPath = $violation->getPropertyPath();
                $cleanedPropertyPath = (new \Symfony\Component\PropertyAccess\PropertyPath($propertyPath))->getElement(0);
                $errors[$cleanedPropertyPath] = $violation->getMessage();
            }

            $response->getBody()->write(json_encode(['errors' => $errors]));

            return $response
                ->withStatus(Controller::HTTP_STATUS_BAD_REQUEST)
                ->withHeader('Content-Type', 'application/json');
        }
    }
}
