<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

$pesquisa = "";

if(isset($_GET['pesquisa'])){
    $pesquisa = mysqli_real_escape_string($conn,$_GET['pesquisa']);
}

$sql = "SELECT
            usuarios.*,
            COUNT(pedidos.id) AS pedidos,
            IFNULL(SUM(pedidos.total),0) AS total_gasto
        FROM usuarios
        LEFT JOIN pedidos
        ON usuarios.id = pedidos.usuario_id
        WHERE usuarios.nome LIKE '%$pesquisa%'
        GROUP BY usuarios.id
        ORDER BY usuarios.id DESC";

$resultado = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Clientes</title>

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

<?php if(isset($_GET['sucesso'])){ ?>

<div class="sucesso">

Cliente atualizado com sucesso!

</div>

<?php } ?>

<?php if(isset($_GET['excluido'])){ ?>

<div class="sucesso">

Cliente excluído com sucesso!

</div>

<?php } ?>

<?php if(isset($_GET['erro'])){ ?>

<div class="erro">

Não é permitido excluir o administrador principal.

</div>

<?php } ?>

<h1>Clientes</h1>

<form class="pesquisaForm" method="GET">

<input
type="text"
name="pesquisa"
placeholder="Pesquisar cliente..."
value="<?= htmlspecialchars($pesquisa); ?>">

<button>

<i class="fa-solid fa-magnifying-glass"></i>

</button>

</form>

<table>

<thead>

<tr>

<th>ID</th>

<th>Nome</th>

<th>Email</th>

<th>CPF</th>

<th>Pedidos</th>

<th>Total Gasto</th>

<th>Nível</th>

<th>Ações</th>

</tr>

</thead>

<tbody>

<?php

while($cliente=mysqli_fetch_assoc($resultado)){

?>

<tr>

<td><?= $cliente['id']; ?></td>

<td><?= htmlspecialchars($cliente['nome']); ?></td>

<td><?= htmlspecialchars($cliente['email']); ?></td>

<td><?= htmlspecialchars($cliente['cpf']); ?></td>

<td><?= $cliente['pedidos']; ?></td>

<td>

R$

<?= number_format($cliente['total_gasto'],2,",","."); ?>

</td>

<td><?= ucfirst($cliente['nivel']); ?></td>

<td>

<a
href="editar.php?id=<?= $cliente['id']; ?>"
class="btnAcao editar">

<i class="fa-solid fa-pen"></i>

</a>

<a
href="excluir.php?id=<?= $cliente['id']; ?>"
class="btnAcao excluir"
onclick="return confirm('Deseja excluir este cliente?');">

<i class="fa-solid fa-trash"></i>

</a>

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