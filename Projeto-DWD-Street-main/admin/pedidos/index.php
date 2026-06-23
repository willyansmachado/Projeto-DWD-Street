<?php
include("../../config/conexao.php");
include("../includes/verifica_login.php");

$pesquisa = "";

if(isset($_GET['pesquisa'])){
    $pesquisa = mysqli_real_escape_string($conn,$_GET['pesquisa']);
}

$sql = "SELECT
            pedidos.id,
            usuarios.nome,
            pedidos.total,
            pedidos.status_pedido,
            pedidos.codigo_rastreio,
            pedidos.forma_pagamento,
            pedidos.data_pedido
        FROM pedidos
        INNER JOIN usuarios
        ON pedidos.usuario_id = usuarios.id
        WHERE usuarios.nome LIKE '%$pesquisa%'
        ORDER BY pedidos.id DESC";

$resultado = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Pedidos</title>

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

<?php if(isset($_GET['editado'])){ ?>

<div class="sucesso">

Pedido atualizado com sucesso!

</div>

<?php } ?>

<div class="titulo">

<h1>Pedidos</h1>

</div>

<div class="titulo">

<h1>Pedidos</h1>

</div>

<form method="GET" class="pesquisaForm">

<input
type="text"
name="pesquisa"
placeholder="Pesquisar cliente..."
value="<?= htmlspecialchars($pesquisa) ?>">

<button>

<i class="fa-solid fa-magnifying-glass"></i>

</button>

</form>

<table>

<thead>

<tr>

<th>ID</th>

<th>Cliente</th>

<th>Total</th>

<th>Status</th>

<th>Pagamento</th>

<th>Rastreio</th>

<th>Data</th>

<th>Ações</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($resultado)>0){

while($pedido=mysqli_fetch_assoc($resultado)){

?>

<tr>

<td>#<?= $pedido['id']; ?></td>

<td><?= htmlspecialchars($pedido['nome']); ?></td>

<td>

R$
<?= number_format($pedido['total'],2,",","."); ?>

</td>

<td>

<?php

$status=$pedido['status_pedido'];

if($status=="Pedido Recebido"){

echo "<span class='status recebido'>$status</span>";

}elseif($status=="Preparando"){

echo "<span class='status preparando'>$status</span>";

}elseif($status=="Enviado"){

echo "<span class='status enviado'>$status</span>";

}elseif($status=="Entregue"){

echo "<span class='status entregue'>$status</span>";

}else{

echo $status;

}

?>

</td>

<td>

<?= htmlspecialchars($pedido['forma_pagamento']); ?>

</td>

<td>

<?= htmlspecialchars($pedido['codigo_rastreio']); ?>

</td>

<td>

<?= date("d/m/Y",strtotime($pedido['data_pedido'])); ?>

</td>

<td>

<a
href="visualizar.php?id=<?= $pedido['id']; ?>"
class="btnAcao visualizar">

<i class="fa-solid fa-eye"></i>

</a>

<a
href="editar.php?id=<?= $pedido['id']; ?>"
class="btnAcao editar">

<i class="fa-solid fa-pen"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="8">

Nenhum pedido encontrado.

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>