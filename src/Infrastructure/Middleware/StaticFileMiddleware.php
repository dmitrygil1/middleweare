<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Domain\Controller\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class StaticFileMiddleware implements MiddlewareInterface
{
    /**
     * Process for get static js/css files
     *
     * @param  ServerRequestInterface  $request  The HTTP request.
     * @param  RequestHandlerInterface  $handler  The request handler.
     * @return ResponseInterface The HTTP response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri  = $request->getUri();
        $path = $uri->getPath();

        $assetsPath = ROOT_PATH . '/assets';

        if (str_starts_with($path, '/assets/')) {
            $filePath = $assetsPath . substr($path, 7);

            if (file_exists($filePath)) {

                $ext      = pathinfo($filePath, PATHINFO_EXTENSION);
                $mimeType = match ($ext) {
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'png' => 'image/png',
                    'jpg', 'jpeg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'svg' => 'image/svg+xml',
                    'woff', 'woff2' => 'font/woff2',
                    'ttf' => 'font/ttf',
                    default => 'application/octet-stream',
                };

                $fileContent = file_get_contents($filePath);
                $response    = new Response();
                $response->getBody()->write($fileContent);
                return $response->withHeader('Content-Type', $mimeType);
            }

            $response = new Response;
            $response->getBody()->write(json_encode([
                'errors' => 'File Not Found',
            ]));

            return $response
                ->withStatus(Controller::HTTP_STATUS_BAD_REQUEST)
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        return $handler->handle($request);
    }
}
