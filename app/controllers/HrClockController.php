<?php

class HrClockController extends Controller
{
    private HrEmployeesModel $employees;
    private HrAttendanceModel $attendance;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->employees = new HrEmployeesModel($db);
        $this->attendance = new HrAttendanceModel($db);
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
        $this->requireCompany();

        $this->render('hr/clock/index', [
            'title' => 'Reloj Control',
            'pageTitle' => 'Reloj control QR',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();

        $token = trim($_POST['qr_token'] ?? '');
        if ($token === '') {
            flash('error', 'Escanea el QR del trabajador.');
            $this->redirect('index.php?route=hr/clock');
        }

        $employee = $this->employees->findByQrToken($token, $companyId);
        if (!$employee) {
            flash('error', 'QR no válido para esta empresa.');
            $this->redirect('index.php?route=hr/clock');
        }

        $today = date('Y-m-d');
        $now = date('H:i');
        $record = $this->attendance->findOpenForDate((int)$employee['id'], $companyId, $today);
        $action = 'entrada';

        if ($record && empty($record['check_out'])) {
            $workedHours = $this->attendance->calculateWorkedHours($record['check_in'], $now);
            $this->attendance->update((int)$record['id'], [
                'check_out' => $now,
                'worked_hours' => $workedHours,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $action = 'salida';
        } else {
            $this->attendance->create([
                'company_id' => $companyId,
                'employee_id' => (int)$employee['id'],
                'date' => $today,
                'check_in' => $now,
                'check_out' => null,
                'worked_hours' => null,
                'overtime_hours' => 0,
                'absence_type' => '',
                'notes' => 'Marcación QR',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        audit($this->db, Auth::user()['id'], 'create', 'hr_clock', (int)$employee['id']);
        $this->redirect('index.php?route=hr/clock/ticket&name=' . urlencode(trim($employee['first_name'] . ' ' . $employee['last_name']))
            . '&rut=' . urlencode($employee['rut'] ?? '')
            . '&action=' . urlencode($action)
            . '&date=' . urlencode($today)
            . '&time=' . urlencode($now));
    }

    public function ticket(): void
    {
        $this->requireLogin();
        $this->requireCompany();

        $this->render('hr/clock/ticket', [
            'title' => 'Ticket de marcación',
            'pageTitle' => 'Ticket',
            'employeeName' => $_GET['name'] ?? '',
            'employeeRut' => $_GET['rut'] ?? '',
            'action' => $_GET['action'] ?? '',
            'date' => $_GET['date'] ?? '',
            'time' => $_GET['time'] ?? '',
        ]);
    }
}
