<?php

declare(strict_types=1);

namespace App\Application\DTO\Authenticate;

class LoginRequestDTO
{
    private string $username;

    private string $password;

    /**
     * Create an instance from an array of data.
     *
     * @param  array  $data  The data to populate the instance.
     * @return static The created instance.
     */
    public static function fromArray(array $data): static
    {
        $instance = new self;
        $instance->setUsername($data['username']);
        $instance->setPassword($data['password']);

        return $instance;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
