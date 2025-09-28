<?php

declare(strict_types=1);

namespace App\Access\Application\Command;

use App\Access\Application\Exception\UserCredentialsIsNotValidException;
use App\Access\Application\Exception\UserWithAlreadyExistsException;
use App\Access\Domain\Model\User;
use App\Access\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final class RegisterUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface     $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * @throws UserWithAlreadyExistsException
     * @throws UserCredentialsIsNotValidException
     */
    public function __invoke(RegisterUserCommand $command): void
    {
        if ($this->userRepository->findByEmail($command->email)) {
            throw new UserWithAlreadyExistsException();
        }

        $user = new User();
        $user->setEmail($command->email);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $command->password);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
    }
}
