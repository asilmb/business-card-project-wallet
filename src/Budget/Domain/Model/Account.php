<?php

declare(strict_types=1);

namespace App\Budget\Domain\Model;

use App\Shared\Domain\ValueObject\Currency;
use App\Shared\Domain\ValueObject\Money;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'budget_account')]
class Account
{
    #[ORM\Id, ORM\GeneratedValue(strategy: 'SEQUENCE'), ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]

    private string $name;

    #[ORM\Embedded(class: Money::class)]
    private Money $balance;

    #[ORM\ManyToOne(targetEntity: Budget::class, inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Budget $budget;

    public function __construct(Budget $budget, string $name, Money $initialBalance)
    {
        $this->budget = $budget;
        $this->name = $name;
        $this->balance = $initialBalance;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBalance(): int
    {
        return $this->balance->getAmount();
    }

    public function getCurrency(): Currency
    {
        return $this->balance->getCurrency();
    }
}
