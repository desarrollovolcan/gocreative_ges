<?php

class ServiceTypesController extends Controller
{
    private ServiceTypesModel $serviceTypes;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->serviceTypes = new ServiceTypesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $types = $this->serviceTypes->all();
        $this->render('maintainers/service-types/index', [
            'title' => 'Tipos de servicios',
            'pageTitle' => 'Tipos de servicios',
            'types' => $types,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $this->render('maintainers/service-types/create', [
            'title' => 'Nuevo tipo de servicio',
            'pageTitle' => 'Nuevo tipo de servicio',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $this->serviceTypes->create([
            'name' => trim($_POST['name'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'service_types');
        flash('success', 'Tipo de servicio creado correctamente.');
        $this->redirect('index.php?route=maintainers/service-types');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $id = (int)($_GET['id'] ?? 0);
        $type = $this->serviceTypes->find($id);
        if (!$type) {
            $this->redirect('index.php?route=maintainers/service-types');
        }
        $this->render('maintainers/service-types/edit', [
            'title' => 'Editar tipo de servicio',
            'pageTitle' => 'Editar tipo de servicio',
            'type' => $type,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->serviceTypes->update($id, [
            'name' => trim($_POST['name'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'service_types', $id);
        flash('success', 'Tipo de servicio actualizado correctamente.');
        $this->redirect('index.php?route=maintainers/service-types');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $linked = $this->db->fetch('SELECT COUNT(*) as total FROM system_services WHERE service_type_id = :id', ['id' => $id]);
        if (!empty($linked['total'])) {
            flash('error', 'No se puede eliminar el tipo de servicio porque tiene servicios asociados.');
            $this->redirect('index.php?route=maintainers/service-types');
        }
        $this->db->execute('DELETE FROM service_types WHERE id = :id', ['id' => $id]);
        audit($this->db, Auth::user()['id'], 'delete', 'service_types', $id);
        flash('success', 'Tipo de servicio eliminado correctamente.');
        $this->redirect('index.php?route=maintainers/service-types');
    }
}
