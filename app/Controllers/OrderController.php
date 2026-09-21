<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Order;
final class OrderController extends Controller { public function index(): void { $this->requireLogin(); $this->render('orders/index', ['title' => 'Meus pedidos | DWD Street', 'userName' => $_SESSION['nome'], 'orders' => (new Order())->forUser((int) $_SESSION['id'])]); } public function show(): void { $this->requireLogin(); $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); $order = $id ? (new Order())->findForUser($id, (int) $_SESSION['id']) : null; if (!$order) { http_response_code(404); $this->render('errors/404', ['title' => 'Pedido não encontrado', 'userName' => $_SESSION['nome']]); return; } $this->render('orders/show', ['title' => 'Pedido #' . $order['id'], 'userName' => $_SESSION['nome'], 'order' => $order]); } }
