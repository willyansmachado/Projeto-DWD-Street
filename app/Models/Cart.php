<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Cart
{
    public function items(int $userId): array
    {
        $sql = 'SELECT c.id, c.produto_id, c.quantidade, p.nome, c.preco, COALESCE(i.imagem, "") AS imagem FROM carrinho c INNER JOIN produtos p ON p.id = c.produto_id LEFT JOIN imagens_produto i ON i.produto_id = p.id AND i.principal = 1 WHERE c.usuario_id = :usuario ORDER BY c.id DESC';
        $statement = Database::connection()->prepare($sql);
        $statement->execute(['usuario' => $userId]);
        return $statement->fetchAll();
    }

    public function add(int $userId, int $productId): void
    {
        $database = Database::connection();
        $existing = $database->prepare('SELECT id, quantidade FROM carrinho WHERE usuario_id = :usuario AND produto_id = :produto LIMIT 1');
        $existing->execute(['usuario' => $userId, 'produto' => $productId]);
        $item = $existing->fetch();

        if ($item) {
            $database->prepare('UPDATE carrinho SET quantidade = :quantidade WHERE id = :id')->execute(['quantidade' => (int) $item['quantidade'] + 1, 'id' => $item['id']]);
            return;
        }

        $product = $database->prepare('SELECT preco_promocional, preco FROM produtos WHERE id = :produto AND ativo = 1 LIMIT 1');
        $product->execute(['produto' => $productId]);
        $price = $product->fetch();
        if (!$price) return;

        $database->prepare('INSERT INTO carrinho (usuario_id, produto_id, quantidade, preco) VALUES (:usuario, :produto, 1, :preco)')->execute([
            'usuario' => $userId,
            'produto' => $productId,
            'preco' => $price['preco_promocional'] ?: $price['preco'],
        ]);
    }

    public function remove(int $userId, int $itemId): void
    {
        Database::connection()->prepare('DELETE FROM carrinho WHERE id = :id AND usuario_id = :usuario')->execute(['id' => $itemId, 'usuario' => $userId]);
    }
}
