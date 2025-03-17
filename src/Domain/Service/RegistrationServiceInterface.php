<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\DomainException\Registration\UsernameAlreadyTakenException;
use App\Domain\Entity\User\User;

interface RegistrationServiceInterface
{
    /**
     * Register a new user with the given username and password.
     *
     * @param string $username The username for the new user.
     * @param string $password The password for the new user.
     * @return User The newly registered user.
     *
     * @throws UsernameAlreadyTakenException If the username is already taken.
     */
    public function register(string $username, string $password): User;
}
