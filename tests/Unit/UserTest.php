<?php

namespace App\Tests\Unit;

use App\Access\Entity\User;
use App\Tests\UnitTestCase;

class UserTest extends UnitTestCase
{

    public function testRolesAreHandledCorrectly(): void
    {
        $user = new User();

        $this->assertCount(1, $user->getRoles());
        $this->assertContains('ROLE_USER', $user->getRoles());

        $user->setRoles(['ROLE_ADMIN']);

        $this->assertCount(2, $user->getRoles());
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
        $this->assertContains('ROLE_USER', $user->getRoles());
    }


    public function testUserIdentifierIsEmail(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');

        $this->assertSame('test@example.com', $user->getUserIdentifier());
    }

}