<?php

class TreasuryController extends Controller
{
    private BankAccountsModel $accounts;
    private BankTransactionsModel $transactions;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->accounts = new BankAccountsModel($db);
        $this->transactions = new BankTransactionsModel($db);
    }

    private function requireCompany(): int
    {
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        return (int)$companyId;
    }

    public function accounts(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $accounts = $this->accounts->byCompany($companyId);
        $this->render('treasury/accounts', [
            'title' => 'Cuentas bancarias',
            'pageTitle' => 'Cuentas bancarias',
            'accounts' => $accounts,
        ]);
    }

    public function storeAccount(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $this->accounts->create([
            'company_id' => $companyId,
            'name' => trim($_POST['name'] ?? ''),
            'bank_name' => trim($_POST['bank_name'] ?? ''),
            'account_number' => trim($_POST['account_number'] ?? ''),
            'currency' => $_POST['currency'] ?? 'CLP',
            'current_balance' => (float)($_POST['current_balance'] ?? 0),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Cuenta bancaria creada.');
        $this->redirect('index.php?route=treasury/accounts');
    }

    public function transactions(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $accounts = $this->accounts->byCompany($companyId);
        $transactions = $this->transactions->byCompany($companyId);
        $this->render('treasury/transactions', [
            'title' => 'Movimientos bancarios',
            'pageTitle' => 'Movimientos bancarios',
            'accounts' => $accounts,
            'transactions' => $transactions,
            'today' => date('Y-m-d'),
        ]);
    }

    public function storeTransaction(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $accountId = (int)($_POST['bank_account_id'] ?? 0);
        $account = $this->accounts->find($accountId);
        if (!$account || (int)$account['company_id'] !== $companyId) {
            flash('error', 'Cuenta bancaria no válida.');
            $this->redirect('index.php?route=treasury/transactions');
        }
        $type = $_POST['type'] ?? 'deposito';
        $amount = (float)($_POST['amount'] ?? 0);
        $currentBalance = (float)($account['current_balance'] ?? 0);
        $newBalance = $type === 'retiro' ? $currentBalance - $amount : $currentBalance + $amount;
        $this->transactions->create([
            'company_id' => $companyId,
            'bank_account_id' => $accountId,
            'transaction_date' => trim($_POST['transaction_date'] ?? date('Y-m-d')),
            'description' => trim($_POST['description'] ?? ''),
            'type' => $type,
            'amount' => $amount,
            'balance' => $newBalance,
            'reference' => trim($_POST['reference'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->accounts->update($accountId, [
            'current_balance' => $newBalance,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Movimiento bancario registrado.');
        $this->redirect('index.php?route=treasury/transactions');
    }
}
