<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller;
final class PageController extends Controller { public function about(): void { $this->render('pages/about', ['title' => 'Sobre | DWD Street', 'userName' => $_SESSION['nome'] ?? 'Visitante']); } public function privacy(): void { $this->render('pages/privacy', ['title' => 'Privacidade | DWD Street', 'userName' => $_SESSION['nome'] ?? 'Visitante']); } }
