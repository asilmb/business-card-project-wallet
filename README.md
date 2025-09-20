# Business card project Wallet

### **Project Setup**

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/asilmb/business-card-project-wallet.git
    cd business-card-project-wallet
    ```
2.  **Copy the environment file:**
    ```bash
    cp .env.dist .env
    ```
3.  **Build and run containers:**
    ```bash
    make build
    ```
4.  **Run the one-time setup command:**
    ```bash
    make setup
    ```

**That's it!** The `make setup` command will do all the dirty work of creating local configuration files. 


# Budget Management Project (Inspired by YNAB)

> **Disclaimer:**  
> This project is **inspired by the ideas and budgeting methodology** popularized by *You Need A Budget LLC (YNAB)*.  
> It is an **independent, educational project** created for demonstration and portfolio purposes only.
>
> - The name **YNAB** and its branding are registered trademarks of You Need A Budget LLC.
> - This project **does not use any original YNAB code, UI design, or assets**.
> - The goal of this project is to **showcase software engineering skills**, not to create a competing product.
> - If this project were to be used commercially, it would need to **avoid using the YNAB name** and have its own unique branding.

[Event storming schema](https://drive.google.com/file/d/1HHVkW5UAp_EyOCdXo18lW1uajrA88s-X/view?usp=sharing)

---

## Project Roadmap

### Epic 1: Core Infrastructure & Authentication (MVP Core) 🏆

- **User Story 1.1:** As a user, I want to register using email and password.
- **User Story 1.2:** As a registered user, I want to log in and receive a JWT token for secure API access.
- **User Story 1.3:** As an authenticated user, I want my requests to protected endpoints to be authorized.

---

### Epic 2: Budget and Accounts Management (YNAB Foundation)
- **User Story 2.1:** As a user, I want to create my first budget (e.g., "Family Budget").
- **User Story 2.2:** As a user, I want to add accounts to my budget (e.g., "Visa Card", "Cash").
    - *Technical details:* Account has `name` and `current_balance`.
- **User Story 2.3:** As a user, I want to see the total sum of money across all my accounts.

---

### Epic 3: Categories and Money Allocation (Rule 1: *Give Every Dollar a Job*)
- **User Story 3.1:** As a user, I want to create category groups (e.g., "Monthly Expenses", "Savings").
- **User Story 3.2:** As a user, I want to create categories inside groups (e.g., "Groceries", "Rent", "Vacation").
    - *Technical details:* Category has `name` and `assigned_balance` (how much money is allocated).
- **User Story 3.3:** As a user, I want to allocate money from accounts to categories.
    - *Key logic:* When I allocate $100 to "Groceries", that category’s `assigned_balance` increases by $100.  
      The **Ready to Assign** balance decreases by $100.
- **User Story 3.4:** As a user, I want to see the total "Ready to Assign" amount.
    - *Formula:* `SUM(account balances) - SUM(category assigned balances)`

---

### Epic 4: Transactions and Expense Tracking
- **User Story 4.1:** As a user, I want to add a transaction (income or expense).
    - *Technical details:* Transaction has `date`, `payee`, `amount`, `account_id`, and `category_id` (if expense).
- **User Story 4.2:** When adding an expense:
    - The account balance decreases.
    - The category balance decreases.
- **User Story 4.3:** When adding income:
    - The account balance increases.
    - The **Ready to Assign** balance increases by the same amount.
- **User Story 4.4:** As a user, I want to see a list of all transactions filtered by account or category.

---

## Roadmap with Priorities

| Release | Included Epics | Description |
|----------|----------------|-------------|
| **MVP** | Epics 1, 2, 3, 4 | Core functionality — user can manage budgets and track transactions. |

---

## Future Improvements (Backlog)
- Multi-currency support.
- Shared budgets for families or teams.
- Import transactions from bank accounts.
- Mobile application.
- Notifications and alerts.

---
