<?php

declare(strict_types=1);

namespace App\Domain\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Controller
{
    public const int HTTP_STATUS_OK = 200;

    public const int HTTP_STATUS_CREATED = 201;

    public const int HTTP_STATUS_BAD_REQUEST = 400;

    public const int HTTP_STATUS_UNAUTHORIZED = 401;

    public function view(Request $request, Response $response, string $template, array $params = []): ResponseInterface
    {
        $view = Twig::fromRequest($request);

        try {
            return $view->render($response, $template, $params);
        } catch (LoaderError|RuntimeError|SyntaxError) {
            throw new HttpInternalServerErrorException($request);
        }
    }

    public function json(Response $response, array $body, int $statusCode = self::HTTP_STATUS_OK): ResponseInterface
    {
        $response->getBody()->write(json_encode($body));

        return $response
            ->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json');
    }
}
