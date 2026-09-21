<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

final class AuthController extends Controller
{
    public function showLogin(): void { $this->render('auth/login', ['title' => 'Entrar | DWD Street', 'userName' => $_SESSION['nome'] ?? 'Visitante', 'error' => null]); }
    public function showRegister(): void { $this->render('auth/register', ['title' => 'Cadastro | DWD Street', 'userName' => 'Visitante', 'error' => null]); }

    public function login(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = (string) ($_POST['senha'] ?? '');
        $user = $email ? (new User())->findByEmail($email) : null;
        if (!$user || !password_verify($password, $user['senha']) || $user['status'] !== 'ativo') { $this->render('auth/login', ['title' => 'Entrar | DWD Street', 'userName' => 'Visitante', 'error' => 'E-mail ou senha inválidos.']); return; }
        $_SESSION['id'] = $user['id']; $_SESSION['nome'] = $user['nome']; $_SESSION['email'] = $user['email']; $_SESSION['nivel'] = $user['nivel'];
        $this->redirect('home');
    }

    public function register(): void
    {
        $name = trim((string) ($_POST['nome'] ?? '')); $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); $password = (string) ($_POST['senha'] ?? '');
        if ($name === '' || !$email || strlen($password) < 8) { $this->render('auth/register', ['title' => 'Cadastro | DWD Street', 'userName' => 'Visitante', 'error' => 'Preencha nome, e-mail válido e senha com ao menos 8 caracteres.']); return; }
        $users = new User();
        if ($users->findByEmail($email)) { $this->render('auth/register', ['title' => 'Cadastro | DWD Street', 'userName' => 'Visitante', 'error' => 'Este e-mail já possui cadastro.']); return; }
        $users->create($name, $email, $password); $this->redirect('login');
    }

    public function logout(): void { session_unset(); session_destroy(); $this->redirect('home'); }
}
