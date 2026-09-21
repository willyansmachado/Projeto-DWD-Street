<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Database;
final class Product {
    public function featured(int $limit = 8): array { $sql = 'SELECT p.id, p.nome, p.preco, p.preco_promocional, COALESCE(i.imagem, "") AS imagem, COALESCE(SUM(e.quantidade), 0) AS estoque FROM produtos p LEFT JOIN imagens_produto i ON i.produto_id = p.id AND i.principal = 1 LEFT JOIN estoque e ON e.produto_id = p.id WHERE p.destaque = 1 AND p.ativo = 1 GROUP BY p.id, p.nome, p.preco, p.preco_promocional, i.imagem ORDER BY p.criado_em DESC LIMIT :limit'; $stmt = Database::connection()->prepare($sql); $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT); $stmt->execute(); return $stmt->fetchAll(); }

    public function list(?int $categoryId = null): array
    {
        $sql = 'SELECT p.id, p.nome, p.preco, p.preco_promocional, COALESCE(i.imagem, "") AS imagem, COALESCE(SUM(e.quantidade), 0) AS estoque FROM produtos p LEFT JOIN imagens_produto i ON i.produto_id = p.id AND i.principal = 1 LEFT JOIN estoque e ON e.produto_id = p.id WHERE p.ativo = 1';
        $params = [];
        if ($categoryId) { $sql .= ' AND p.categoria_id = :categoria'; $params['categoria'] = $categoryId; }
        $sql .= ' GROUP BY p.id, p.nome, p.preco, p.preco_promocional, i.imagem ORDER BY p.criado_em DESC';
        $statement = Database::connection()->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll();
    }
}
