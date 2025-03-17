<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Infrastructure\Service\SessionServiceInterface;
use Override;

readonly class SessionService implements SessionServiceInterface
{
    #[Override]
    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    #[Override]
    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    #[Override]
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
