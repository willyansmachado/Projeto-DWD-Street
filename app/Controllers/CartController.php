<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Cart;
final class CartController extends Controller { public function index(): void { $this->requireLogin(); $items = (new Cart())->items((int) $_SESSION['id']); $total = array_sum(array_map(static fn(array $item): float => (float) $item['preco'] * (int) $item['quantidade'], $items)); $this->render('cart/index', ['title' => 'Carrinho | DWD Street', 'userName' => $_SESSION['nome'], 'items' => $items, 'total' => $total]); } public function add(): void { $this->requireLogin(); $id = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT); if ($id) (new Cart())->add((int) $_SESSION['id'], $id); $this->redirect('carrinho'); } public function remove(): void { $this->requireLogin(); $id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT); if ($id) (new Cart())->remove((int) $_SESSION['id'], $id); $this->redirect('carrinho'); } }
