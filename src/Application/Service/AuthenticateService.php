<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\DomainException\Authenticate\UnauthenticatedException;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserRepositoryInterface;
use App\Domain\Service\AuthenticateServiceInterface;
use App\Domain\Service\PasswordHashServiceInterface;
use App\Infrastructure\Service\SessionServiceInterface;
use Override;

readonly class AuthenticateService implements AuthenticateServiceInterface
{
    private const string USER_USERNAME_SESSION_KEY = 'username';

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHashServiceInterface $passwordHashService,
        private SessionServiceInterface $sessionService,
    ) {}

    #[Override]
    public function authenticate(string $username, string $password): User
    {
        $user = $this->userRepository->findByUsername($username);
        if (is_null($user)) {
            throw new UnauthenticatedException;
        }

        if (! $this->passwordHashService->verify($password, $user->getPassword())) {
            throw new UnauthenticatedException;
        }

        $this->sessionService->put(self::USER_USERNAME_SESSION_KEY, $user->getUsername());

        return $user;
    }

    #[Override]
    public function logout(): void
    {
        $this->sessionService->remove(self::USER_USERNAME_SESSION_KEY);
    }

    #[Override]
    public function getAuthenticatedUsername(): ?string
    {
        return $this->sessionService->get(self::USER_USERNAME_SESSION_KEY);
    }
}
