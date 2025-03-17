<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Service\PasswordHashServiceInterface;
use Override;

readonly class PasswordHashService implements PasswordHashServiceInterface
{
    private const string ALGO = PASSWORD_BCRYPT;

    #[Override]
    public function hash(string $password): string
    {
        return password_hash($password, self::ALGO);
    }

    #[Override]
    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
