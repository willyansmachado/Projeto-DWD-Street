<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class LegacyController extends Controller
{
    public function page(): void
    {
        $page = (string) ($_GET['pagina'] ?? '');
        $allowed = ['montador', 'pagamento', 'obrigado', 'recuperar-senha'];

        if (!in_array($page, $allowed, true)) {
            http_response_code(404);
            $this->render('errors/404', ['title' => 'Página não encontrada', 'userName' => $_SESSION['nome'] ?? 'Visitante']);
            return;
        }

        require BASE_PATH . '/app/Views/legacy/' . $page . '.php';
    }
}
