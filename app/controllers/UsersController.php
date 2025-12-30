<?php

class UsersController extends Controller
{
    private UsersModel $users;
    private RolesModel $roles;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->users = new UsersModel($db);
        $this->roles = new RolesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $users = $this->users->allActive(current_company_id());
        $this->render('users/index', [
            'title' => 'Usuarios',
            'pageTitle' => 'Usuarios',
            'users' => $users,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $roles = $this->roles->all();
        $companies = (new CompaniesModel($this->db))->active();
        $this->render('users/create', [
            'title' => 'Nuevo Usuario',
            'pageTitle' => 'Nuevo Usuario',
            'roles' => $roles,
            'companies' => $companies,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $companyId = (int)($_POST['company_id'] ?? 0);
        $company = $this->db->fetch('SELECT id FROM companies WHERE id = :id', ['id' => $companyId]);
        if (!$company) {
            flash('error', 'Selecciona una empresa válida.');
            $this->redirect('index.php?route=users/create');
        }
        if (!Validator::required($name) || !Validator::email($email)) {
            flash('error', 'Completa los campos obligatorios.');
            $this->redirect('index.php?route=users/create');
        }
        $avatarResult = upload_avatar($_FILES['avatar'] ?? null, 'user');
        if (!empty($avatarResult['error'])) {
            flash('error', $avatarResult['error']);
            $this->redirect('index.php?route=users/create');
        }

        $this->users->create([
            'company_id' => $companyId,
            'name' => $name,
            'email' => $email,
            'password' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
            'role_id' => (int)($_POST['role_id'] ?? 2),
            'avatar_path' => $avatarResult['path'],
            'signature' => trim($_POST['signature'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'users');
        flash('success', 'Usuario creado correctamente.');
        $this->redirect('index.php?route=users');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->db->fetch(
            'SELECT * FROM users WHERE id = :id AND deleted_at IS NULL',
            ['id' => $id]
        );
        $roles = $this->roles->all();
        $companies = (new CompaniesModel($this->db))->active();
        $this->render('users/edit', [
            'title' => 'Editar Usuario',
            'pageTitle' => 'Editar Usuario',
            'user' => $user,
            'roles' => $roles,
            'companies' => $companies,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $companyId = (int)($_POST['company_id'] ?? 0);
        $company = $this->db->fetch('SELECT id FROM companies WHERE id = :id', ['id' => $companyId]);
        if (!$company) {
            flash('error', 'Selecciona una empresa válida.');
            $this->redirect('index.php?route=users/edit&id=' . $id);
        }
        if (!Validator::required($name) || !Validator::email($email)) {
            flash('error', 'Completa los campos obligatorios.');
            $this->redirect('index.php?route=users/edit&id=' . $id);
        }
        $data = [
            'company_id' => $companyId,
            'name' => $name,
            'email' => $email,
            'role_id' => (int)($_POST['role_id'] ?? 2),
            'signature' => trim($_POST['signature'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $avatarResult = upload_avatar($_FILES['avatar'] ?? null, 'user');
        if (!empty($avatarResult['error'])) {
            flash('error', $avatarResult['error']);
            $this->redirect('index.php?route=users/edit&id=' . $id);
        }
        if (!empty($avatarResult['path'])) {
            $data['avatar_path'] = $avatarResult['path'];
        }
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $this->users->update($id, $data);
        if (!empty($_SESSION['user']) && (int)($_SESSION['user']['id'] ?? 0) === $id) {
            $_SESSION['user']['company_id'] = $companyId;
            $companyRow = $this->db->fetch('SELECT name FROM companies WHERE id = :id', ['id' => $companyId]);
            $_SESSION['user']['company_name'] = $companyRow['name'] ?? $_SESSION['user']['company_name'];
        }
        audit($this->db, Auth::user()['id'], 'update', 'users', $id);
        flash('success', 'Usuario actualizado correctamente.');
        $this->redirect('index.php?route=users');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $user = $this->db->fetch('SELECT id FROM users WHERE id = :id AND deleted_at IS NULL', ['id' => $id]);
        if (!$user) {
            flash('error', 'No encontramos el usuario.');
            $this->redirect('index.php?route=users');
        }
        $this->users->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'users', $id);
        flash('success', 'Usuario eliminado correctamente.');
        $this->redirect('index.php?route=users');
    }

    public function assignCompany(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $companies = (new CompaniesModel($this->db))->active();
        $users = $this->db->fetchAll(
            'SELECT users.*, roles.name as role, companies.name as company_name
             FROM users
             JOIN roles ON users.role_id = roles.id
             LEFT JOIN companies ON users.company_id = companies.id
             WHERE users.deleted_at IS NULL
             ORDER BY users.name'
        );
        $this->render('users/assign_company', [
            'title' => 'Asociar usuario a empresa',
            'pageTitle' => 'Asociar usuario a empresa',
            'users' => $users,
            'companies' => $companies,
        ]);
    }

    public function updateCompany(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $userId = (int)($_POST['user_id'] ?? 0);
        $companyId = (int)($_POST['company_id'] ?? 0);
        $user = $this->db->fetch('SELECT id FROM users WHERE id = :id AND deleted_at IS NULL', ['id' => $userId]);
        if (!$user) {
            flash('error', 'Usuario no encontrado.');
            $this->redirect('index.php?route=users/assign-company');
        }
        $company = $this->db->fetch('SELECT id, name FROM companies WHERE id = :id', ['id' => $companyId]);
        if (!$company) {
            flash('error', 'Empresa no encontrada.');
            $this->redirect('index.php?route=users/assign-company');
        }
        $this->users->update($userId, [
            'company_id' => $companyId,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        if (!empty($_SESSION['user']) && (int)($_SESSION['user']['id'] ?? 0) === $userId) {
            $_SESSION['user']['company_id'] = $companyId;
            $_SESSION['user']['company_name'] = $company['name'];
        }
        audit($this->db, Auth::user()['id'], 'update', 'users_company', $userId);
        flash('success', 'Empresa asociada correctamente.');
        $this->redirect('index.php?route=users/assign-company');
    }
}
