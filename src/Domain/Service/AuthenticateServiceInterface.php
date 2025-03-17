<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\DomainException\Authenticate\UnauthenticatedException;
use App\Domain\Entity\User\User;

interface AuthenticateServiceInterface
{
    /**
     * Authenticate a user with the provided username and password.
     *
     * @param  string  $username  The username to authenticate.
     * @param  string  $password  The password to authenticate.
     * @return User The authenticated user.
     *
     * @throws UnauthenticatedException If authentication fails.
     */
    public function authenticate(string $username, string $password): User;

    /**
     * Returns the username of the authenticated user, if any.
     *
     * @return string|null The username of the authenticated user or null.
     */
    public function getAuthenticatedUsername(): ?string;

    /**
     * Log the user out of the current session.
     */
    public function logout(): void;
}
