<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\CatalogController;
use App\Controllers\HomeController;
use App\Controllers\LegacyController;
use App\Controllers\OrderController;
use App\Controllers\PageController;

final class Router
{
    public function dispatch(): void
    {
        $route = trim((string) ($_GET['rota'] ?? 'home'), '/');
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $routes = [
            'home' => [HomeController::class, 'index'],
            'catalogo' => [CatalogController::class, 'index'],
            'login' => [AuthController::class, $method === 'POST' ? 'login' : 'showLogin'],
            'cadastro' => [AuthController::class, $method === 'POST' ? 'register' : 'showRegister'],
            'sair' => [AuthController::class, 'logout'],
            'carrinho' => [CartController::class, 'index'],
            'carrinho/adicionar' => [CartController::class, 'add'],
            'carrinho/remover' => [CartController::class, 'remove'],
            'pedidos' => [OrderController::class, 'index'],
            'pedido' => [OrderController::class, 'show'],
            'sobre' => [PageController::class, 'about'],
            'privacidade' => [PageController::class, 'privacy'],
            'legado' => [LegacyController::class, 'page'],
        ];

        if (!isset($routes[$route])) {
            http_response_code(404);
            View::render('errors/404', ['title' => 'Página não encontrada', 'userName' => $_SESSION['nome'] ?? 'Visitante']);
            return;
        }

        [$controller, $action] = $routes[$route];
        (new $controller())->$action();
    }
}
