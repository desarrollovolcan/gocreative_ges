<?php

class SystemServicesController extends Controller
{
    private SystemServicesModel $services;
    private ServiceTypesModel $serviceTypes;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->services = new SystemServicesModel($db);
        $this->serviceTypes = new ServiceTypesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $services = $this->services->allWithType();
        $this->render('maintainers/services/index', [
            'title' => 'Servicios',
            'pageTitle' => 'Servicios',
            'services' => $services,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $types = $this->serviceTypes->all();
        $this->render('maintainers/services/create', [
            'title' => 'Nuevo servicio',
            'pageTitle' => 'Nuevo servicio',
            'types' => $types,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $this->services->create([
            'service_type_id' => (int)($_POST['service_type_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'cost' => (float)($_POST['cost'] ?? 0),
            'currency' => trim($_POST['currency'] ?? 'CLP'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'system_services');
        $this->redirect('index.php?route=maintainers/services');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $id = (int)($_GET['id'] ?? 0);
        $service = $this->services->find($id);
        if (!$service) {
            $this->redirect('index.php?route=maintainers/services');
        }
        $types = $this->serviceTypes->all();
        $this->render('maintainers/services/edit', [
            'title' => 'Editar servicio',
            'pageTitle' => 'Editar servicio',
            'service' => $service,
            'types' => $types,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->services->update($id, [
            'service_type_id' => (int)($_POST['service_type_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'cost' => (float)($_POST['cost'] ?? 0),
            'currency' => trim($_POST['currency'] ?? 'CLP'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'system_services', $id);
        $this->redirect('index.php?route=maintainers/services');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('DELETE FROM system_services WHERE id = :id', ['id' => $id]);
        audit($this->db, Auth::user()['id'], 'delete', 'system_services', $id);
        $this->redirect('index.php?route=maintainers/services');
    }
}
