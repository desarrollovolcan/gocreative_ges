<?php

class ProjectsController extends Controller
{
    private ProjectsModel $projects;
    private ClientsModel $clients;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->projects = new ProjectsModel($db);
        $this->clients = new ClientsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $conditions = ['projects.deleted_at IS NULL'];
        $params = [];
        $clientId = (int)($_GET['client_id'] ?? 0);
        if ($clientId > 0) {
            $conditions[] = 'projects.client_id = :client_id';
            $params['client_id'] = $clientId;
        }
        $status = trim($_GET['status'] ?? '');
        if ($status !== '') {
            $conditions[] = 'projects.status = :status';
            $params['status'] = $status;
        }
        $mandante = trim($_GET['mandante'] ?? '');
        if ($mandante !== '') {
            $conditions[] = 'projects.mandante_name LIKE :mandante';
            $params['mandante'] = '%' . $mandante . '%';
        }
        $name = trim($_GET['name'] ?? '');
        if ($name !== '') {
            $conditions[] = 'projects.name LIKE :name';
            $params['name'] = '%' . $name . '%';
        }
        $where = implode(' AND ', $conditions);
        $projects = $this->db->fetchAll("SELECT projects.*, clients.name as client_name FROM projects JOIN clients ON projects.client_id = clients.id WHERE {$where} ORDER BY projects.id DESC", $params);
        $clients = $this->clients->active();
        $this->render('projects/index', [
            'title' => 'Proyectos',
            'pageTitle' => 'Proyectos',
            'projects' => $projects,
            'clients' => $clients,
            'filters' => [
                'client_id' => $clientId,
                'status' => $status,
                'mandante' => $mandante,
                'name' => $name,
            ],
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $clients = $this->clients->active();
        $this->render('projects/create', [
            'title' => 'Nuevo Proyecto',
            'pageTitle' => 'Nuevo Proyecto',
            'clients' => $clients,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $startDate = trim($_POST['start_date'] ?? '');
        $deliveryDate = trim($_POST['delivery_date'] ?? '');
        $value = trim($_POST['value'] ?? '');
        $data = [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'status' => $_POST['status'] ?? 'cotizado',
            'start_date' => $startDate !== '' ? $startDate : null,
            'delivery_date' => $deliveryDate !== '' ? $deliveryDate : null,
            'value' => $value !== '' ? $value : null,
            'mandante_name' => trim($_POST['mandante_name'] ?? ''),
            'mandante_rut' => trim($_POST['mandante_rut'] ?? ''),
            'mandante_phone' => trim($_POST['mandante_phone'] ?? ''),
            'mandante_email' => trim($_POST['mandante_email'] ?? ''),
            'notes' => trim($_POST['notes'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->projects->create($data);
        audit($this->db, Auth::user()['id'], 'create', 'projects');
        $this->redirect('index.php?route=projects');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $project = $this->projects->find($id);
        if (!$project) {
            $this->redirect('index.php?route=projects');
        }
        $clients = $this->clients->active();
        $this->render('projects/edit', [
            'title' => 'Editar Proyecto',
            'pageTitle' => 'Editar Proyecto',
            'project' => $project,
            'clients' => $clients,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $startDate = trim($_POST['start_date'] ?? '');
        $deliveryDate = trim($_POST['delivery_date'] ?? '');
        $value = trim($_POST['value'] ?? '');
        $data = [
            'client_id' => (int)($_POST['client_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'status' => $_POST['status'] ?? 'cotizado',
            'start_date' => $startDate !== '' ? $startDate : null,
            'delivery_date' => $deliveryDate !== '' ? $deliveryDate : null,
            'value' => $value !== '' ? $value : null,
            'mandante_name' => trim($_POST['mandante_name'] ?? ''),
            'mandante_rut' => trim($_POST['mandante_rut'] ?? ''),
            'mandante_phone' => trim($_POST['mandante_phone'] ?? ''),
            'mandante_email' => trim($_POST['mandante_email'] ?? ''),
            'notes' => trim($_POST['notes'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->projects->update($id, $data);
        audit($this->db, Auth::user()['id'], 'update', 'projects', $id);
        $this->redirect('index.php?route=projects');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $project = $this->projects->find($id);
        if (!$project) {
            $this->redirect('index.php?route=projects');
        }
        $checklist = $this->db->fetchAll('SELECT * FROM project_tasks WHERE project_id = :id ORDER BY id ASC', ['id' => $id]);
        $this->render('projects/show', [
            'title' => 'Detalle Proyecto',
            'pageTitle' => 'Detalle Proyecto',
            'project' => $project,
            'checklist' => $checklist,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->projects->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'projects', $id);
        $this->redirect('index.php?route=projects');
    }
}
