<?php
declare(strict_types=1);


namespace App\Tests\Resource\Access;

use App\Access\Domain\Model\User;

final class TestUser
{
    public static function create(): User
    {
        return new User();
    }
}