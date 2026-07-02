<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = "SELECT
            pedidos.*,
            usuarios.nome,
            usuarios.email,
            usuarios.cpf
        FROM pedidos
        INNER JOIN usuarios
        ON usuarios.id = pedidos.usuario_id
        WHERE pedidos.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) == 0){
    die("Pedido não encontrado.");
}

$pedido = mysqli_fetch_assoc($resultado);

/*
|--------------------------------------------------------------------------
| PRODUTOS DO PEDIDO
|--------------------------------------------------------------------------
*/

$sqlItens = "SELECT *
             FROM itens_pedido
             WHERE pedido_id=?";

$stmtItens = mysqli_prepare($conn,$sqlItens);

mysqli_stmt_bind_param($stmtItens,"i",$id);

mysqli_stmt_execute($stmtItens);

$itens = mysqli_stmt_get_result($stmtItens);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Pedido #<?= $pedido['id']; ?></title>

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

<div class="titulo">

<h1>

Pedido #<?= $pedido['id']; ?>

</h1>

<a href="index.php" class="btnVoltar">

<i class="fa-solid fa-arrow-left"></i>

Voltar

</a>

</div>

<div class="cardPainel">

<h2>Cliente</h2>

<p><strong>Nome:</strong> <?= htmlspecialchars($pedido['nome']); ?></p>

<p><strong>Email:</strong> <?= htmlspecialchars($pedido['email']); ?></p>

<p><strong>CPF:</strong> <?= htmlspecialchars($pedido['cpf']); ?></p>

</div>

<div class="cardPainel">

<h2>Entrega</h2>

<p><strong>CEP:</strong> <?= htmlspecialchars($pedido['cep']); ?></p>

<p><strong>Endereço:</strong> <?= htmlspecialchars($pedido['endereco']); ?></p>

<p><strong>Número:</strong> <?= htmlspecialchars($pedido['numero']); ?></p>

<p><strong>Bairro:</strong> <?= htmlspecialchars($pedido['bairro']); ?></p>

</div>

<div class="cardPainel">

<h2>Pagamento</h2>

<p><strong>Forma:</strong> <?= htmlspecialchars($pedido['forma_pagamento']); ?></p>

<p><strong>Subtotal:</strong> R$ <?= number_format($pedido['subtotal'],2,",","."); ?></p>

<p><strong>Frete:</strong> R$ <?= number_format($pedido['frete'],2,",","."); ?></p>

<p><strong>Total:</strong> <strong>R$ <?= number_format($pedido['total'],2,",","."); ?></strong></p>

</div>

<div class="cardPainel">

<h2>Status</h2>

<p><?= htmlspecialchars($pedido['status_pedido']); ?></p>

<p><strong>Rastreio:</strong> <?= htmlspecialchars($pedido['codigo_rastreio']); ?></p>

<p><strong>Data:</strong>

<?= date("d/m/Y H:i",strtotime($pedido['data_pedido'])); ?>

</p>

</div>

<div class="cardPainel">

<h2>Produtos</h2>

<table>

<tr>

<th>Produto</th>

<th>Preço</th>

<th>Qtd</th>

<th>Total</th>

</tr>

<?php while($item=mysqli_fetch_assoc($itens)){ ?>

<tr>

<td><?= htmlspecialchars($item['produto_nome']); ?></td>

<td>

R$

<?= number_format($item['preco'],2,",","."); ?>

</td>

<td>

<?= $item['quantidade']; ?>

</td>

<td>

R$

<?= number_format(
$item['preco']*$item['quantidade'],
2,
",",
"."
); ?>

</td>

</tr>

<?php } ?>

</table>

</div>

<div style="margin-top:30px;">

<button
onclick="window.print()"
class="btnSalvar">

<i class="fa-solid fa-print"></i>

Imprimir Pedido

</button>

</div>

</div>

</div>

</div>

</body>

</html>