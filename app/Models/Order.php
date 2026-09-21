<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Order
{
    public function forUser(int $userId): array
    {
        $statement = Database::connection()->prepare('SELECT id, total, status, criado_em FROM pedidos WHERE usuario_id = :usuario ORDER BY criado_em DESC');
        $statement->execute(['usuario' => $userId]);
        return $statement->fetchAll();
    }

    public function findForUser(int $orderId, int $userId): ?array
    {
        $statement = Database::connection()->prepare('SELECT id, total, status, criado_em FROM pedidos WHERE id = :id AND usuario_id = :usuario LIMIT 1');
        $statement->execute(['id' => $orderId, 'usuario' => $userId]);
        return $statement->fetch() ?: null;
    }
}
