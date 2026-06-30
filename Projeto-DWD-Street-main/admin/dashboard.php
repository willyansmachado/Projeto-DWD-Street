<?php

include("../config/conexao.php");
include("includes/verificar_login.php");

$sql = "SELECT COUNT(*) AS total FROM produtos";
$res = mysqli_query($conn,$sql);
$totalProdutos = mysqli_fetch_assoc($res)['total'];

/* TOTAL CLIENTES */

$sql = "SELECT COUNT(*) AS total FROM usuarios WHERE nivel='cliente'";
$res = mysqli_query($conn,$sql);
$totalClientes = mysqli_fetch_assoc($res)['total'];

/* TOTAL PEDIDOS */

$sql = "SELECT COUNT(*) AS total FROM pedidos";
$res = mysqli_query($conn,$sql);
$totalPedidos = mysqli_fetch_assoc($res)['total'];

/* FATURAMENTO */

$sql = "SELECT SUM(total) AS faturamento FROM pedidos";
$res = mysqli_query($conn, $sql);

$faturamento = mysqli_fetch_assoc($res)['faturamento'];

if ($faturamento == null) {
    $faturamento = 0;
}

/* ÚLTIMOS PEDIDOS */

$sqlPedidos = "SELECT
usuarios.nome,
pedidos.total,
pedidos.status

FROM pedidos

INNER JOIN usuarios
ON usuarios.id = pedidos.usuario_id

ORDER BY pedidos.id DESC

LIMIT 5";

$ultimosPedidos = mysqli_query($conn, $sqlPedidos);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Dashboard</title>

<link rel="stylesheet" href="css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include("includes/menu.php"); ?>

<div class="main">

<?php include("includes/topbar.php"); ?>

<div class="conteudo">

<h1>Dashboard</h1>

<div class="cards">

<div class="card">

<i class="fa-solid fa-box"></i>

<h2><?= $totalProdutos ?></h2>

<p>Produtos</p>

</div>

<div class="card">

<i class="fa-solid fa-users"></i>

<h2><?= $totalClientes ?></h2>

<p>Clientes</p>

</div>

<div class="card">

<i class="fa-solid fa-cart-shopping"></i>

<h2><?= $totalPedidos ?></h2>

<p>Pedidos</p>

</div>

<div class="card">

<i class="fa-solid fa-dollar-sign"></i>

<h2>

R$

<?= number_format($faturamento,2,",","."); ?>

</h2>

<p>Faturamento</p>

</div>

</div>

<div class="dashboard-grid" style="grid-template-columns:1fr;">

<div class="box">

<h2>

Últimos Pedidos

</h2>

<table>

<tr>

<th>Cliente</th>

<th>Total</th>

<th>Status</th>

</tr>

<?php

while($pedido=mysqli_fetch_assoc($ultimosPedidos)){

?>

<tr>

<td><?= $pedido['nome']; ?></td>

<td>

R$

<?= number_format($pedido['total'],2,",","."); ?>

</td>

<td><?= $pedido['status']; ?></td>

</tr>

<?php } ?>

</table>

</div>

<div class="box">

</div>

</div>

</div>

</div>

</body>

</html>