<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface PasswordHashServiceInterface
{
    /**
     * Hash the given password.
     *
     * @param  string  $password  The password to hash.
     * @return string The hashed password.
     */
    public function hash(string $password): string;

    /**
     * Verify the given password against a hash.
     *
     * @param  string  $password  The password to verify.
     * @param  string  $hash  The hash to compare against.
     * @return bool True if the password matches the hash, false otherwise.
     */
    public function verify(string $password, string $hash): bool;
}
