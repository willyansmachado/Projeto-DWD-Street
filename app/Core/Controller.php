<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $route): never
    {
        header('Location: index.php?rota=' . rawurlencode($route));
        exit;
    }

    protected function requireLogin(): void
    {
        if (!isset($_SESSION['id'])) {
            $this->redirect('login');
        }
    }
}
