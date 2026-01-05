<?php

class AccountingController extends Controller
{
    private AccountingAccountsModel $accounts;
    private AccountingJournalsModel $journals;
    private AccountingJournalLinesModel $journalLines;
    private AccountingPeriodsModel $periods;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->accounts = new AccountingAccountsModel($db);
        $this->journals = new AccountingJournalsModel($db);
        $this->journalLines = new AccountingJournalLinesModel($db);
        $this->periods = new AccountingPeriodsModel($db);
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

    public function chart(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $accounts = $this->accounts->byCompany($companyId);
        $this->render('accounting/chart', [
            'title' => 'Plan de cuentas',
            'pageTitle' => 'Plan de cuentas',
            'accounts' => $accounts,
        ]);
    }

    public function chartCreate(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $accounts = $this->accounts->byCompany($companyId);
        $this->render('accounting/chart-create', [
            'title' => 'Nueva cuenta contable',
            'pageTitle' => 'Nueva cuenta contable',
            'accounts' => $accounts,
        ]);
    }

    public function chartStore(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $code = trim($_POST['code'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $type = trim($_POST['type'] ?? '');
        $parentId = (int)($_POST['parent_id'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $allowedTypes = ['activo', 'pasivo', 'patrimonio', 'resultado'];
        if ($code === '' || $name === '' || !in_array($type, $allowedTypes, true)) {
            flash('error', 'Completa código, nombre y tipo de cuenta válido.');
            $this->redirect('index.php?route=accounting/chart/create');
        }
        $existing = $this->accounts->findByCode($companyId, $code);
        if ($existing) {
            flash('error', 'Ya existe una cuenta con ese código.');
            $this->redirect('index.php?route=accounting/chart/create');
        }
        $level = 1;
        if ($parentId > 0) {
            $parent = $this->accounts->find($parentId);
            if ($parent && (int)$parent['company_id'] === $companyId) {
                if (($parent['type'] ?? '') !== $type) {
                    flash('error', 'El tipo debe coincidir con la cuenta madre.');
                    $this->redirect('index.php?route=accounting/chart/create');
                }
                $level = (int)($parent['level'] ?? 1) + 1;
            } else {
                $parentId = 0;
            }
        }
        $this->accounts->create([
            'company_id' => $companyId,
            'code' => $code,
            'name' => $name,
            'type' => $type,
            'level' => $level,
            'parent_id' => $parentId ?: null,
            'is_active' => $isActive,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Cuenta contable creada correctamente.');
        $this->redirect('index.php?route=accounting/chart');
    }

    public function chartEdit(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $accountId = (int)($_GET['id'] ?? 0);
        $account = $this->accounts->find($accountId);
        if (!$account || (int)$account['company_id'] !== $companyId) {
            flash('error', 'Cuenta contable no encontrada.');
            $this->redirect('index.php?route=accounting/chart');
        }
        $accounts = $this->accounts->byCompany($companyId);
        $children = $this->accounts->byParent($companyId, $accountId);
        $this->render('accounting/chart-edit', [
            'title' => 'Editar cuenta contable',
            'pageTitle' => 'Editar cuenta contable',
            'account' => $account,
            'accounts' => $accounts,
            'children' => $children,
        ]);
    }

    public function chartUpdate(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $accountId = (int)($_POST['id'] ?? 0);
        $account = $this->accounts->find($accountId);
        if (!$account || (int)$account['company_id'] !== $companyId) {
            flash('error', 'Cuenta contable no encontrada.');
            $this->redirect('index.php?route=accounting/chart');
        }
        $code = trim($_POST['code'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $type = trim($_POST['type'] ?? '');
        $parentId = (int)($_POST['parent_id'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $allowedTypes = ['activo', 'pasivo', 'patrimonio', 'resultado'];
        if ($code === '' || $name === '' || !in_array($type, $allowedTypes, true)) {
            flash('error', 'Completa código, nombre y tipo de cuenta válido.');
            $this->redirect('index.php?route=accounting/chart/edit&id=' . $accountId);
        }
        $existing = $this->accounts->findByCode($companyId, $code, $accountId);
        if ($existing) {
            flash('error', 'Ya existe una cuenta con ese código.');
            $this->redirect('index.php?route=accounting/chart/edit&id=' . $accountId);
        }
        if ($parentId === $accountId) {
            flash('error', 'La cuenta no puede ser su propia madre.');
            $this->redirect('index.php?route=accounting/chart/edit&id=' . $accountId);
        }
        $level = 1;
        $parentIdValue = null;
        if ($parentId > 0) {
            $parent = $this->accounts->find($parentId);
            if (!$parent || (int)$parent['company_id'] !== $companyId) {
                flash('error', 'Cuenta madre inválida.');
                $this->redirect('index.php?route=accounting/chart/edit&id=' . $accountId);
            }
            if (($parent['type'] ?? '') !== $type) {
                flash('error', 'El tipo debe coincidir con la cuenta madre.');
                $this->redirect('index.php?route=accounting/chart/edit&id=' . $accountId);
            }
            $level = (int)($parent['level'] ?? 1) + 1;
            $parentIdValue = $parentId;
        }
        $this->accounts->update($accountId, [
            'code' => $code,
            'name' => $name,
            'type' => $type,
            'level' => $level,
            'parent_id' => $parentIdValue,
            'is_active' => $isActive,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Cuenta contable actualizada.');
        $this->redirect('index.php?route=accounting/chart');
    }

    public function journals(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $journals = $this->journals->listWithTotals($companyId);
        $this->render('accounting/journals', [
            'title' => 'Libro diario',
            'pageTitle' => 'Libro diario',
            'journals' => $journals,
        ]);
    }

    public function journalsCreate(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $accounts = $this->accounts->byCompany($companyId);
        $this->render('accounting/journals-create', [
            'title' => 'Nuevo asiento contable',
            'pageTitle' => 'Nuevo asiento contable',
            'accounts' => $accounts,
            'today' => date('Y-m-d'),
        ]);
    }

    public function journalsStore(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $entryNumber = trim($_POST['entry_number'] ?? '');
        $entryDate = trim($_POST['entry_date'] ?? date('Y-m-d'));
        $description = trim($_POST['description'] ?? '');
        $accountIds = $_POST['account_id'] ?? [];
        $lineDescriptions = $_POST['line_description'] ?? [];
        $debits = $_POST['debit'] ?? [];
        $credits = $_POST['credit'] ?? [];
        $lines = [];
        $totalDebit = 0.0;
        $totalCredit = 0.0;
        foreach ($accountIds as $index => $accountId) {
            $accountId = (int)$accountId;
            $debit = (float)($debits[$index] ?? 0);
            $credit = (float)($credits[$index] ?? 0);
            if ($accountId <= 0 || ($debit <= 0 && $credit <= 0)) {
                continue;
            }
            $lines[] = [
                'account_id' => $accountId,
                'line_description' => trim((string)($lineDescriptions[$index] ?? '')),
                'debit' => $debit,
                'credit' => $credit,
            ];
            $totalDebit += $debit;
            $totalCredit += $credit;
        }
        if ($entryNumber === '' || empty($lines)) {
            flash('error', 'Debes ingresar número de asiento y al menos una línea.');
            $this->redirect('index.php?route=accounting/journals/create');
        }
        if (round($totalDebit, 2) !== round($totalCredit, 2)) {
            flash('error', 'El asiento no cuadra: débito y crédito deben ser iguales.');
            $this->redirect('index.php?route=accounting/journals/create');
        }
        $journalId = $this->journals->create([
            'company_id' => $companyId,
            'entry_number' => $entryNumber,
            'entry_date' => $entryDate,
            'description' => $description,
            'source' => 'manual',
            'status' => 'registrado',
            'created_by' => (int)(Auth::user()['id'] ?? 0),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        foreach ($lines as $line) {
            $this->journalLines->create([
                'journal_id' => $journalId,
                'account_id' => $line['account_id'],
                'line_description' => $line['line_description'],
                'debit' => $line['debit'],
                'credit' => $line['credit'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        flash('success', 'Asiento contable registrado.');
        $this->redirect('index.php?route=accounting/journals');
    }

    public function ledger(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $ledger = $this->db->fetchAll(
            'SELECT aa.id, aa.code, aa.name, aa.type,
                    COALESCE(SUM(ajl.debit), 0) as total_debit,
                    COALESCE(SUM(ajl.credit), 0) as total_credit
             FROM accounting_accounts aa
             LEFT JOIN accounting_journal_lines ajl ON aa.id = ajl.account_id
             LEFT JOIN accounting_journals aj ON ajl.journal_id = aj.id
             WHERE aa.company_id = :company_id
             GROUP BY aa.id
             ORDER BY aa.code ASC',
            ['company_id' => $companyId]
        );
        $this->render('accounting/ledger', [
            'title' => 'Libro mayor',
            'pageTitle' => 'Libro mayor',
            'ledger' => $ledger,
        ]);
    }

    public function trialBalance(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $balance = $this->db->fetchAll(
            'SELECT aa.code, aa.name, aa.type,
                    COALESCE(SUM(ajl.debit), 0) as total_debit,
                    COALESCE(SUM(ajl.credit), 0) as total_credit
             FROM accounting_accounts aa
             LEFT JOIN accounting_journal_lines ajl ON aa.id = ajl.account_id
             LEFT JOIN accounting_journals aj ON ajl.journal_id = aj.id
             WHERE aa.company_id = :company_id
             GROUP BY aa.id
             ORDER BY aa.code ASC',
            ['company_id' => $companyId]
        );
        $this->render('accounting/trial-balance', [
            'title' => 'Balance de comprobación',
            'pageTitle' => 'Balance de comprobación',
            'balance' => $balance,
        ]);
    }

    public function financialStatements(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $totals = $this->db->fetchAll(
            'SELECT aa.type,
                    COALESCE(SUM(ajl.debit), 0) as total_debit,
                    COALESCE(SUM(ajl.credit), 0) as total_credit
             FROM accounting_accounts aa
             LEFT JOIN accounting_journal_lines ajl ON aa.id = ajl.account_id
             LEFT JOIN accounting_journals aj ON ajl.journal_id = aj.id
             WHERE aa.company_id = :company_id
             GROUP BY aa.type',
            ['company_id' => $companyId]
        );
        $statement = [
            'activo' => 0.0,
            'pasivo' => 0.0,
            'patrimonio' => 0.0,
            'resultado' => 0.0,
        ];
        foreach ($totals as $row) {
            $net = (float)$row['total_debit'] - (float)$row['total_credit'];
            $statement[$row['type'] ?? 'resultado'] = $net;
        }
        $this->render('accounting/financial-statements', [
            'title' => 'Estados financieros',
            'pageTitle' => 'Estados financieros',
            'statement' => $statement,
        ]);
    }

    public function periods(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $periods = $this->periods->byCompany($companyId);
        $this->render('accounting/periods', [
            'title' => 'Cierres contables',
            'pageTitle' => 'Cierres contables',
            'periods' => $periods,
        ]);
    }

    public function periodsStore(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $period = trim($_POST['period'] ?? '');
        if ($period === '') {
            flash('error', 'Indica el período contable.');
            $this->redirect('index.php?route=accounting/periods');
        }
        $this->periods->create([
            'company_id' => $companyId,
            'period' => $period,
            'status' => 'abierto',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Periodo contable creado.');
        $this->redirect('index.php?route=accounting/periods');
    }

    public function periodsClose(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $periodId = (int)($_POST['period_id'] ?? 0);
        $period = $this->periods->find($periodId);
        if (!$period || (int)$period['company_id'] !== $companyId) {
            flash('error', 'Periodo contable no encontrado.');
            $this->redirect('index.php?route=accounting/periods');
        }
        $this->periods->update($periodId, [
            'status' => 'cerrado',
            'closed_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Periodo contable cerrado.');
        $this->redirect('index.php?route=accounting/periods');
    }
}
