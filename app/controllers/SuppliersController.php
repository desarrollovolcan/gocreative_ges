<?php

class SuppliersController extends Controller
{
    private SuppliersModel $suppliers;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->suppliers = new SuppliersModel($db);
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
        $suppliers = $this->suppliers->active($companyId);

        $this->render('suppliers/index', [
            'title' => 'Proveedores',
            'pageTitle' => 'Proveedores',
            'suppliers' => $suppliers,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->requireCompany();
        $this->render('suppliers/create', [
            'title' => 'Nuevo proveedor',
            'pageTitle' => 'Nuevo proveedor',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();

        $this->suppliers->create([
            'company_id' => $companyId,
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        audit($this->db, Auth::user()['id'], 'create', 'suppliers');
        flash('success', 'Proveedor creado correctamente.');
        $this->redirect('index.php?route=suppliers');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $id = (int)($_GET['id'] ?? 0);
        $supplier = $this->suppliers->findForCompany($id, $companyId);
        if (!$supplier) {
            $this->redirect('index.php?route=suppliers');
        }

        $this->render('suppliers/edit', [
            'title' => 'Editar proveedor',
            'pageTitle' => 'Editar proveedor',
            'supplier' => $supplier,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $id = (int)($_POST['id'] ?? 0);
        $supplier = $this->suppliers->findForCompany($id, $companyId);
        if (!$supplier) {
            flash('error', 'Proveedor no encontrado.');
            $this->redirect('index.php?route=suppliers');
        }

        $this->suppliers->update($id, [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        audit($this->db, Auth::user()['id'], 'update', 'suppliers', $id);
        flash('success', 'Proveedor actualizado correctamente.');
        $this->redirect('index.php?route=suppliers');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $id = (int)($_POST['id'] ?? 0);
        $supplier = $this->suppliers->findForCompany($id, $companyId);
        if (!$supplier) {
            flash('error', 'Proveedor no encontrado.');
            $this->redirect('index.php?route=suppliers');
        }

        $this->suppliers->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'suppliers', $id);
        flash('success', 'Proveedor eliminado correctamente.');
        $this->redirect('index.php?route=suppliers');
    }
}
