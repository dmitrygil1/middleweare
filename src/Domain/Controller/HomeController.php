<?php

declare(strict_types=1);

namespace App\Domain\Controller;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController extends Controller
{
    public function __construct(
        public Container $container,
    ) {}

    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        return $this->view($request, $response, 'home.html.twig');
    }
}
