<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\View;
use App\Models\Product;
final class HomeController { public function index(): void { View::render('home/index', ['title' => 'DWD Street | Moda urbana', 'userName' => $_SESSION['nome'] ?? 'Visitante', 'products' => (new Product())->featured()]); } }
