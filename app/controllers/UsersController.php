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
        $users = $this->users->allActive();
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
        $this->render('users/create', [
            'title' => 'Nuevo Usuario',
            'pageTitle' => 'Nuevo Usuario',
            'roles' => $roles,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if (!Validator::required($name) || !Validator::email($email)) {
            $_SESSION['error'] = 'Completa los campos obligatorios.';
            $this->redirect('index.php?route=users/create');
        }
        $avatarResult = upload_avatar($_FILES['avatar'] ?? null, 'user');
        if (!empty($avatarResult['error'])) {
            $_SESSION['error'] = $avatarResult['error'];
            $this->redirect('index.php?route=users/create');
        }

        $this->users->create([
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
        $this->redirect('index.php?route=users');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->users->find($id);
        $roles = $this->roles->all();
        $this->render('users/edit', [
            'title' => 'Editar Usuario',
            'pageTitle' => 'Editar Usuario',
            'user' => $user,
            'roles' => $roles,
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
        if (!Validator::required($name) || !Validator::email($email)) {
            $_SESSION['error'] = 'Completa los campos obligatorios.';
            $this->redirect('index.php?route=users/edit&id=' . $id);
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'role_id' => (int)($_POST['role_id'] ?? 2),
            'signature' => trim($_POST['signature'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $avatarResult = upload_avatar($_FILES['avatar'] ?? null, 'user');
        if (!empty($avatarResult['error'])) {
            $_SESSION['error'] = $avatarResult['error'];
            $this->redirect('index.php?route=users/edit&id=' . $id);
        }
        if (!empty($avatarResult['path'])) {
            $data['avatar_path'] = $avatarResult['path'];
        }
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $this->users->update($id, $data);
        audit($this->db, Auth::user()['id'], 'update', 'users', $id);
        $this->redirect('index.php?route=users');
    }

    public function delete(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->users->softDelete($id);
        audit($this->db, Auth::user()['id'], 'delete', 'users', $id);
        $this->redirect('index.php?route=users');
    }
}
