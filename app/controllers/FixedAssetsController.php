<?php

class FixedAssetsController extends Controller
{
    private FixedAssetsModel $assets;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->assets = new FixedAssetsModel($db);
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
        $assets = $this->assets->byCompany($companyId);
        $this->render('fixed-assets/index', [
            'title' => 'Activos fijos',
            'pageTitle' => 'Activos fijos',
            'assets' => $assets,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->requireCompany();
        $this->render('fixed-assets/create', [
            'title' => 'Registrar activo fijo',
            'pageTitle' => 'Registrar activo fijo',
            'today' => date('Y-m-d'),
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $value = (float)($_POST['acquisition_value'] ?? 0);
        $accumulated = (float)($_POST['accumulated_depreciation'] ?? 0);
        $bookValue = max(0, $value - $accumulated);
        $this->assets->create([
            'company_id' => $companyId,
            'name' => trim($_POST['name'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'acquisition_date' => trim($_POST['acquisition_date'] ?? date('Y-m-d')),
            'acquisition_value' => $value,
            'depreciation_method' => $_POST['depreciation_method'] ?? 'linea_recta',
            'useful_life_months' => (int)($_POST['useful_life_months'] ?? 0),
            'accumulated_depreciation' => $accumulated,
            'book_value' => $bookValue,
            'status' => $_POST['status'] ?? 'activo',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        flash('success', 'Activo fijo registrado.');
        $this->redirect('index.php?route=fixed-assets');
    }
}
