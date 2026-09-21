<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Category
{
    public function active(): array
    {
        return Database::connection()
            ->query('SELECT id, nome, slug FROM categorias WHERE ativo = 1 ORDER BY nome')
            ->fetchAll();
    }
}
