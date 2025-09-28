<?php

declare(strict_types=1);

namespace App\Access\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;

final class RegisterUserCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,
        #[Assert\NotBlank]
        #[Assert\Length(min: 8)]
        public string $password
    ) {
    }
}
