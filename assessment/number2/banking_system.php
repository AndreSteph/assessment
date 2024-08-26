<?php

class BankAccount {
    private $accountHolder;
    private $balance;
    private $password;

    public function __construct($accountHolder, $password) {
        $this->accountHolder = $accountHolder;
        $this->balance = 0;
        $this->password = $password;
    }

    public function getAccountHolder() {
        return $this->accountHolder;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            echo "Successfully deposited $amount. New balance is {$this->balance}.\n";
        } else {
            echo "Deposit amount must be positive.\n";
        }
    }

    public function withdraw($amount) {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            echo "Successfully withdrew $amount. New balance is {$this->balance}.\n";
        } else {
            echo "Insufficient funds or invalid amount.\n";
        }
    }

    public function getBalance() {
        return $this->balance;
    }

    public function authenticate($password) {
        return $this->password === $password;
    }
}

class BankAccountManager {
    private $accounts = [];

    public function createAccount($accountHolder, $password) {
        if (!isset($this->accounts[$accountHolder])) {
            $this->accounts[$accountHolder] = new BankAccount($accountHolder, $password);
            echo "Account created successfully for $accountHolder.\n";
        } else {
            echo "Account already exists for $accountHolder.\n";
        }
    }

    public function getAccount($accountHolder) {
        if (isset($this->accounts[$accountHolder])) {
            return $this->accounts[$accountHolder];
        } else {
            echo "Account does not exist for $accountHolder.\n";
            return null;
        }
    }

    public function authenticate($accountHolder, $password) {
        if (isset($this->accounts[$accountHolder])) {
            $account = $this->accounts[$accountHolder];
            if ($account->authenticate($password)) {
                echo "Authentication successful for $accountHolder.\n";
                return true;
            } else {
                echo "Incorrect password for $accountHolder.\n";
                return false;
            }
        } else {
            echo "Account does not exist for $accountHolder.\n";
            return false;
        }
    }

    public function getAllAccounts() {
        return $this->accounts;
    }
}

// Command-line interface for managing multiple accounts
function prompt($message) {
    echo $message;
    return trim(fgets(STDIN));
}

$manager = new BankAccountManager();

while (true) {
    echo "\nBank Account Manager\n";
    echo "1. Create Account\n";
    echo "2. Authenticate and Perform Transactions\n";
    echo "3. Show All Accounts\n";
    echo "4. Exit\n";
    
    $choice = prompt("Choose an option: ");

    switch ($choice) {
        case '1':
            $accountHolder = prompt("Enter account holder's name: ");
            $password = prompt("Set a password for the account: ");
            $manager->createAccount($accountHolder, $password);
            break;
        
        case '2':
            $accountHolder = prompt("Enter account holder's name: ");
            $password = prompt("Enter password: ");
            if ($manager->authenticate($accountHolder, $password)) {
                $account = $manager->getAccount($accountHolder);
                while (true) {
                    echo "\nTransactions for {$accountHolder}\n";
                    echo "1. Deposit\n";
                    echo "2. Withdraw\n";
                    echo "3. Show Balance\n";
                    echo "4. Logout\n";
                    
                    $transactionChoice = prompt("Choose a transaction: ");
                    
                    switch ($transactionChoice) {
                        case '1':
                            $amount = (float) prompt("Enter deposit amount: ");
                            $account->deposit($amount);
                            break;
                        case '2':
                            $amount = (float) prompt("Enter withdrawal amount: ");
                            $account->withdraw($amount);
                            break;
                        case '3':
                            echo "Current balance: {$account->getBalance()}\n";
                            break;
                        case '4':
                            echo "Logging out...\n";
                            break 2;
                        default:
                            echo "Invalid option. Try again.\n";
                            break;
                    }
                }
            }
            break;
        
        case '3':
            echo "\nAll Accounts:\n";
            foreach ($manager->getAllAccounts() as $accountHolder => $account) {
                echo "Account Holder: {$accountHolder}, Balance: {$account->getBalance()}\n";
            }
            break;

        case '4':
            echo "Exiting...\n";
            exit;

        default:
            echo "Invalid option. Please choose a valid option.\n";
            break;
    }
}
?>
