<?php

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $companies = (new CompaniesModel($this->db))->active();
        $this->renderPublic('auth/login', [
            'title' => 'Acceso Administrador',
            'pageTitle' => 'Acceso Administrador',
            'hidePortalHeader' => true,
            'companies' => $companies,
        ]);
    }

    public function login(): void
    {
        verify_csrf();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $companyId = (int)($_POST['company_id'] ?? 0);

        if ($companyId === 0) {
            $_SESSION['error'] = 'Selecciona una empresa.';
            $this->redirect('login.php');
        }

        $company = $this->db->fetch('SELECT * FROM companies WHERE id = :id', ['id' => $companyId]);
        if (!$company) {
            $_SESSION['error'] = 'Empresa no encontrada.';
            $this->redirect('login.php');
        }

        $user = $this->db->fetch('SELECT users.*, roles.name as role FROM users JOIN roles ON users.role_id = roles.id WHERE users.email = :email AND users.company_id = :company_id AND users.deleted_at IS NULL', [
            'email' => $email,
            'company_id' => $companyId,
        ]);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Credenciales inválidas.';
            $this->redirect('login.php');
        }

        Auth::login([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'role_id' => $user['role_id'],
            'avatar_path' => $user['avatar_path'] ?? null,
            'company_id' => $company['id'],
            'company_name' => $company['name'],
        ]);
        $this->redirect('index.php');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('login.php');
    }

    public function switchCompany(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        $companies = (new CompaniesModel($this->db))->active();
        $this->render('auth/switch-company', [
            'title' => 'Cambiar empresa',
            'pageTitle' => 'Cambiar empresa',
            'companies' => $companies,
            'currentCompanyId' => (int)(Auth::user()['company_id'] ?? 0),
        ]);
    }

    public function updateCompany(): void
    {
        $this->requireLogin();
        $this->requireRole('admin');
        verify_csrf();
        $companyId = (int)($_POST['company_id'] ?? 0);
        $company = $this->db->fetch('SELECT id, name FROM companies WHERE id = :id', ['id' => $companyId]);
        if (!$company) {
            flash('error', 'Empresa no encontrada.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $_SESSION['user']['company_id'] = $companyId;
        $_SESSION['user']['company_name'] = $company['name'];
        flash('success', 'Empresa cambiada correctamente.');
        $this->redirect('index.php?route=dashboard');
    }
}
