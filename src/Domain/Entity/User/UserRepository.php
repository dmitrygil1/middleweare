<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Override;

readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}


    #[Override]
    public function create(string $username, string $password): User
    {
        $user = (new User)
            ->setUsername($username)
            ->setPassword($password)
            ->setCreatedAt(new DateTimeImmutable('now'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    #[Override]
    public function findByUsername(string $username): ?User
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(\App\Domain\Entity\User\User::class, 'u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
