<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class JsonBodyParserMiddleware implements MiddlewareInterface
{
    /**
     * Parse JSON body if the request's Content-Type is 'application/json'.
     *
     * @param  ServerRequestInterface  $request  The HTTP request.
     * @param  RequestHandlerInterface  $handler  The request handler.
     * @return ResponseInterface The HTTP response.
     */
    #[Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $contentType = $request->getHeaderLine('Content-Type');

        if (str_contains($contentType, 'application/json')) {
            $contents = json_decode(file_get_contents('php://input'), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request = $request->withParsedBody($contents);
            }
        }

        return $handler->handle($request);
    }
}
