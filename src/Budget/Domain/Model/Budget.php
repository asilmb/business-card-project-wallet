<?php

declare(strict_types=1);

namespace App\Budget\Domain\Model;

use App\Access\Domain\Model\User;
use App\Budget\Domain\Exception\BudgetCreateException;
use App\Shared\Domain\ValueObject\Currency;
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

    #[ORM\Column(length: 3, enumType: Currency::class)]
    private Currency $currency;


    /**
     * @param ArrayCollection<int, Account> $accounts
     */
    private function __construct(
        User            $owner,
        string          $name,
        Currency        $currency,
        ArrayCollection $accounts = new ArrayCollection(),
    ) {
        $this->owner = $owner;
        $this->name = $name;
        $this->currency = $currency;
        $this->accounts = $accounts;
    }

    public static function create(User $owner, string $name, Currency $currency): Budget
    {
        return new self($owner, $name, $currency);
    }

    public function addAccount(string $name, Money $initialBalance): void
    {
        if ($initialBalance->currency !== $this->currency) {
            throw new BudgetCreateException('Account currency must match the budget currency.');
        }

        $account = new Account($this, $name, $initialBalance);
        $this->accounts->add($account);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
