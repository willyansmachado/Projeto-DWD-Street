<?php
session_start();

include("../../config/conexao.php");
include("../includes/verificar_login.php");

$sql = "SELECT
p.*,
c.nome AS categoria,
m.nome AS marca

FROM produtos p

INNER JOIN categorias c
ON c.id = p.categoria_id

LEFT JOIN marcas m
ON m.id = p.marca_id

ORDER BY p.id DESC";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Produtos</title>

<link rel="stylesheet" href="../css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include("../includes/menu.php"); ?>

<div class="main">

<?php include("../includes/topbar.php"); ?>

<div class="conteudo">

<h1>Produtos</h1>

<a href="criar.php" class="btn">

<i class="fa-solid fa-plus"></i>

Novo Produto

</a>

<br><br>

<table>

<tr>

<th>ID</th>

<th>Nome</th>

<th>Categoria</th>

<th>Marca</th>

<th>Preço</th>

<th>Status</th>

<th>Ações</th>

</tr>

<?php while($produto=mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?= $produto['id'] ?></td>

<td><?= htmlspecialchars($produto['nome']) ?></td>

<td><?= htmlspecialchars($produto['categoria']) ?></td>

<td><?= htmlspecialchars($produto['marca'] ?? '-') ?></td>

<td>

R$ <?= number_format($produto['preco'],2,",",".") ?>

</td>

<td>

<?= $produto['ativo'] ? "Ativo" : "Inativo"; ?>

</td>

<td>

<a class="btn-editar"

href="editar.php?id=<?= $produto['id'] ?>">

Editar

</a>

<a class="btn-excluir"

href="excluir.php?id=<?= $produto['id'] ?>"

onclick="return confirm('Deseja excluir este produto?')">

Excluir

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>

</html>