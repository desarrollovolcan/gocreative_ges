<?php

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->renderPublic('auth/login', [
            'title' => 'Acceso Administrador',
            'pageTitle' => 'Acceso Administrador',
            'hidePortalHeader' => true,
        ]);
    }

    public function login(): void
    {
        verify_csrf();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->db->fetch('SELECT users.*, roles.name as role FROM users JOIN roles ON users.role_id = roles.id WHERE users.email = :email AND users.deleted_at IS NULL', [
            'email' => $email,
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
        ]);
        $this->redirect('index.php');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('login.php');
    }
}
