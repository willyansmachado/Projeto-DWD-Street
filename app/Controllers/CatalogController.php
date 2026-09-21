<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Category;
use App\Models\Product;
final class CatalogController extends Controller { public function index(): void { $category = filter_input(INPUT_GET, 'categoria', FILTER_VALIDATE_INT) ?: null; $this->render('catalog/index', ['title' => 'Catálogo | DWD Street', 'userName' => $_SESSION['nome'] ?? 'Visitante', 'categories' => (new Category())->active(), 'products' => (new Product())->list($category), 'selectedCategory' => $category]); } }
