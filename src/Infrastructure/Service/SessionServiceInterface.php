<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

interface SessionServiceInterface
{
    /**
     * Retrieve a value from the session by key.
     *
     * @param  string  $key  The key to look up in the session.
     * @return mixed The value associated with the key, or null if not found.
     */
    public function get(string $key): mixed;

    /**
     * Store a value in the session with a specific key.
     *
     * @param  string  $key  The key to associate with the value.
     * @param  mixed  $value  The value to store in the session.
     */
    public function put(string $key, mixed $value): void;

    /**
     * Remove a value from the session by key.
     *
     * @param  string  $key  The key of the value to remove.
     */
    public function remove(string $key): void;
}
