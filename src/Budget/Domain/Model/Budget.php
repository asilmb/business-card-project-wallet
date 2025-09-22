<?php

declare(strict_types=1);

namespace App\Budget\Domain\Model;

use App\Access\Domain\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'budget')]
class Budget
{
    #[ORM\Id, ORM\GeneratedValue(strategy: 'SEQUENCE'), ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    /** @var Collection<int, Account> */
    #[ORM\OneToMany(mappedBy: 'budget', targetEntity: Account::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $accounts;

    private function __construct(
        User $owner,
        string $name,
        ArrayCollection $accounts = new ArrayCollection())
    {
        $this->owner = $owner;
        $this->name = $name;
        $this->accounts = $accounts;
    }

    public static function create(User $owner, string $name): Budget
    {
        return new self($owner, $name);
    }

    public static function createWithAccounts(User $owner, string $name, ArrayCollection $accounts): Budget
    {
        return new self($owner, $name, $accounts);
    }

    public function addAccount(string $name, Money $initialBalance): void
    {
        $account = new Account($this, $name, $initialBalance);
        $this->accounts->add($account);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }
}