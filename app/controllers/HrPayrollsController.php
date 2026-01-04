<?php

class HrPayrollsController extends Controller
{
    private HrPayrollsModel $payrolls;
    private HrEmployeesModel $employees;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->payrolls = new HrPayrollsModel($db);
        $this->employees = new HrEmployeesModel($db);
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

        $this->render('hr/payrolls/index', [
            'title' => 'Remuneraciones',
            'pageTitle' => 'Remuneraciones y nómina',
            'payrolls' => $this->payrolls->byCompany($companyId),
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();

        $this->render('hr/payrolls/create', [
            'title' => 'Nueva remuneración',
            'pageTitle' => 'Nueva remuneración',
            'employees' => $this->employees->active($companyId),
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();

        $employeeId = (int)($_POST['employee_id'] ?? 0);
        $periodStart = trim($_POST['period_start'] ?? '');
        $periodEnd = trim($_POST['period_end'] ?? '');
        if ($employeeId === 0 || $periodStart === '' || $periodEnd === '') {
            flash('error', 'Selecciona trabajador y período.');
            $this->redirect('index.php?route=hr/payrolls/create');
        }

        $employee = $this->employees->findForCompany($employeeId, $companyId);
        if (!$employee) {
            flash('error', 'Trabajador no válido.');
            $this->redirect('index.php?route=hr/payrolls/create');
        }

        $baseSalary = (float)($_POST['base_salary'] ?? 0);
        $bonuses = (float)($_POST['bonuses'] ?? 0);
        $deductions = (float)($_POST['deductions'] ?? 0);
        $netPay = $baseSalary + $bonuses - $deductions;

        $this->payrolls->create([
            'company_id' => $companyId,
            'employee_id' => $employeeId,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'base_salary' => $baseSalary,
            'bonuses' => $bonuses,
            'deductions' => $deductions,
            'net_pay' => $netPay,
            'status' => $_POST['status'] ?? 'borrador',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        audit($this->db, Auth::user()['id'], 'create', 'hr_payrolls');
        flash('success', 'Remuneración creada correctamente.');
        $this->redirect('index.php?route=hr/payrolls');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $id = (int)($_POST['id'] ?? 0);
        $payroll = $this->payrolls->findForCompany($id, $companyId);
        if (!$payroll) {
            $this->redirect('index.php?route=hr/payrolls');
        }

        $this->db->execute('DELETE FROM hr_payrolls WHERE id = :id AND company_id = :company_id', [
            'id' => $id,
            'company_id' => $companyId,
        ]);
        audit($this->db, Auth::user()['id'], 'delete', 'hr_payrolls', $id);
        flash('success', 'Remuneración eliminada correctamente.');
        $this->redirect('index.php?route=hr/payrolls');
    }
}
