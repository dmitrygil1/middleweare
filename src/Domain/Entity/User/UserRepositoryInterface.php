<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * Creates a new User entity with the given username and password.
     *
     * @param  string  $username  The username for the new User.
     * @param  string  $password  The password for the new User.
     * @return User The created User entity.
     */
    public function create(string $username, string $password): User;

    /**
     * Finds a User entity by its username.
     *
     * @param  string  $username  The username of the User to find.
     * @return User|null The User entity if found, null otherwise.
     */
    public function findByUsername(string $username): ?User;
}
