<?php
declare(strict_types=1);
namespace App\Core;
final class View {
    public static function render(string $view, array $data = []): void { extract($data, EXTR_SKIP); require BASE_PATH . '/app/Views/' . $view . '.php'; }
    public static function escape(?string $value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
}
