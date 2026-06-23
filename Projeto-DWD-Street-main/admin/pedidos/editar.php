<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if(!isset($_GET['id'])){
    header("Location:index.php");
    exit();
}

$id = (int) $_GET['id'];

$sql = "SELECT
            pedidos.*,
            usuarios.nome
        FROM pedidos
        INNER JOIN usuarios
        ON usuarios.id = pedidos.usuario_id
        WHERE pedidos.id=?";

$stmt = mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado)==0){
    die("Pedido não encontrado.");
}

$pedido = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Editar Pedido</title>

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

<h1>Editar Pedido #<?= $pedido['id']; ?></h1>

<a href="index.php" class="btnVoltar">

<i class="fa-solid fa-arrow-left"></i>

Voltar

</a>

</div>

<form
action="atualizar.php"
method="POST"
class="formulario">

<input
type="hidden"
name="id"
value="<?= $pedido['id']; ?>">

<div class="grupo">

<label>Cliente</label>

<input
type="text"
value="<?= htmlspecialchars($pedido['nome']); ?>"
disabled>

</div>

<div class="grupo">

<label>Status do Pedido</label>

<select name="status_pedido">

<option value="Pedido Recebido" <?= $pedido['status_pedido']=="Pedido Recebido"?"selected":""; ?>>
Pedido Recebido
</option>

<option value="Preparando" <?= $pedido['status_pedido']=="Preparando"?"selected":""; ?>>
Preparando
</option>

<option value="Enviado" <?= $pedido['status_pedido']=="Enviado"?"selected":""; ?>>
Enviado
</option>

<option value="Entregue" <?= $pedido['status_pedido']=="Entregue"?"selected":""; ?>>
Entregue
</option>

<option value="Cancelado" <?= $pedido['status_pedido']=="Cancelado"?"selected":""; ?>>
Cancelado
</option>

</select>

</div>

<div class="grupo">

<label>Código de Rastreio</label>

<input
type="text"
name="codigo_rastreio"
value="<?= htmlspecialchars($pedido['codigo_rastreio']); ?>">

</div>

<div class="grupo">

<label>Forma de Pagamento</label>

<input
type="text"
value="<?= htmlspecialchars($pedido['forma_pagamento']); ?>"
disabled>

</div>

<div class="grupo">

<label>Total</label>

<input
type="text"
value="R$ <?= number_format($pedido['total'],2,',','.'); ?>"
disabled>

</div>

<div class="botoes">

<button
class="btnSalvar">

<i class="fa-solid fa-floppy-disk"></i>

Salvar Alterações

</button>

<a
href="index.php"
class="btnCancelar">

Cancelar

</a>

</div>

</form>

</div>

</div>

</div>

</body>

</html>