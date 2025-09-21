<?php

namespace App\Access\Infrastructure\Fixtures\Test;

use App\Access\Domain\Model\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public const TEST_USER_EMAIL = 'test@example.com';
    public const TEST_USER_PASSWORD = 'MySecretPassword123';

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(self::TEST_USER_EMAIL);

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            self::TEST_USER_PASSWORD
        ));

        $manager->persist($user);
        $manager->flush();
    }
}
