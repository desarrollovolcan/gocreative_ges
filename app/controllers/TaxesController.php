<?php

class TaxesController extends Controller
{
    private TaxPeriodsModel $periods;
    private TaxWithholdingsModel $withholdings;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->periods = new TaxPeriodsModel($db);
        $this->withholdings = new TaxWithholdingsModel($db);
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

    public function index(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $periods = $this->periods->byCompany($companyId);
        $selectedPeriodId = (int)($_GET['period_id'] ?? ($periods[0]['id'] ?? 0));
        $withholdings = $selectedPeriodId > 0 ? $this->withholdings->byPeriod($selectedPeriodId) : [];
        $this->render('taxes/index', [
            'title' => 'Impuestos',
            'pageTitle' => 'Impuestos',
            'periods' => $periods,
            'withholdings' => $withholdings,
            'selectedPeriodId' => $selectedPeriodId,
        ]);
    }

    public function storePeriod(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $period = trim($_POST['period'] ?? '');
        if ($period === '') {
            flash('error', 'Indica el período tributario.');
            $this->redirect('index.php?route=taxes');
        }
        $this->periods->create([
            'company_id' => $companyId,
            'period' => $period,
            'iva_debito' => (float)($_POST['iva_debito'] ?? 0),
            'iva_credito' => (float)($_POST['iva_credito'] ?? 0),
            'remanente' => (float)($_POST['remanente'] ?? 0),
            'total_retenciones' => (float)($_POST['total_retenciones'] ?? 0),
            'impuesto_unico' => (float)($_POST['impuesto_unico'] ?? 0),
            'status' => $_POST['status'] ?? 'pendiente',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Período tributario creado.');
        $this->redirect('index.php?route=taxes');
    }

    public function storeWithholding(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $periodId = (int)($_POST['period_id'] ?? 0);
        $type = trim($_POST['type'] ?? '');
        $baseAmount = (float)($_POST['base_amount'] ?? 0);
        $rate = (float)($_POST['rate'] ?? 0);
        $amount = $baseAmount * ($rate / 100);
        if ($periodId <= 0 || $type === '') {
            flash('error', 'Selecciona un período y tipo de retención.');
            $this->redirect('index.php?route=taxes');
        }
        $this->withholdings->create([
            'company_id' => $companyId,
            'period_id' => $periodId,
            'type' => $type,
            'base_amount' => $baseAmount,
            'rate' => $rate,
            'amount' => $amount,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $this->db->execute(
            'UPDATE tax_periods SET total_retenciones = total_retenciones + :amount, updated_at = NOW() WHERE id = :id AND company_id = :company_id',
            [
                'amount' => $amount,
                'id' => $periodId,
                'company_id' => $companyId,
            ]
        );
        flash('success', 'Retención registrada.');
        $this->redirect('index.php?route=taxes&period_id=' . $periodId);
    }
}
