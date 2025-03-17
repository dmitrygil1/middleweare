<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\DomainException\Registration\UsernameAlreadyTakenException;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserRepositoryInterface;
use App\Domain\Service\PasswordHashServiceInterface;
use App\Domain\Service\RegistrationServiceInterface;
use Override;

readonly class RegistrationService implements RegistrationServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHashServiceInterface $passwordHashService,
    ) {}

    /**
     * @throws UsernameAlreadyTakenException
     */
    #[Override]
    public function register(string $username, string $password): User
    {
        $userWithUsername = $this->userRepository->findByUsername($username);
        if (! is_null($userWithUsername)) {
            throw new UsernameAlreadyTakenException;
        }

        $hashedPassword = $this->passwordHashService->hash($password);

        return $this->userRepository->create($username, $hashedPassword);
    }
}
