<?php

declare(strict_types=1);

namespace App\Domain\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        return $this->view($request, $response, 'dashboard.html.twig', [
            'username' => $request->getAttribute('username'),
        ]);
    }
}
