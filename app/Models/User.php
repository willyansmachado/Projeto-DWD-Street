<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class User
{
    public function findByEmail(string $email): ?array
    {
        $statement = Database::connection()->prepare('SELECT id, nome, email, senha, nivel, status FROM usuarios WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        return $statement->fetch() ?: null;
    }

    public function create(string $name, string $email, string $password): bool
    {
        $statement = Database::connection()->prepare('INSERT INTO usuarios (nome, email, senha, nivel, status) VALUES (:nome, :email, :senha, "cliente", "ativo")');
        return $statement->execute(['nome' => $name, 'email' => $email, 'senha' => password_hash($password, PASSWORD_DEFAULT)]);
    }
}
