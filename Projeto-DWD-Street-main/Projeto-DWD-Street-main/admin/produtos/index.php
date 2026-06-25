<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

$pesquisa = "";

if(isset($_GET['pesquisa'])){
    $pesquisa = mysqli_real_escape_string($conn,$_GET['pesquisa']);
}

$sql = "SELECT * FROM produtos
        WHERE nome LIKE '%$pesquisa%'
        ORDER BY id DESC";

$resultado = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Produtos | DWD Street</title>

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

Produto cadastrado com sucesso!

</div>
<?php if(isset($_GET['editado'])){ ?>

<div class="sucesso">

Produto atualizado com sucesso!

</div>

<?php } ?>

<?php if(isset($_GET['excluido'])){ ?>

<div class="sucesso">

Produto excluído com sucesso!

</div>

<?php } ?>

<?php } ?>

<div class="titulo">

<h1>Produtos</h1>

<a href="adicionar.php" class="btnNovo">

<i class="fa-solid fa-plus"></i>

Novo Produto

</a>

</div>

<form method="GET">

<input
type="text"
name="pesquisa"
placeholder="Pesquisar produto..."
value="<?= $pesquisa ?>"
class="pesquisa">

<button>

<i class="fa-solid fa-magnifying-glass"></i>

</button>

</form>

<table>

<thead>

<tr>

<th>ID</th>

<th>Imagem</th>

<th>Nome</th>

<th>Categoria</th>

<th>Preço</th>

<th>Estoque</th>

<th>Ações</th>

</tr>

</thead>

<tbody>

<?php while($produto=mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?= $produto['id']; ?></td>

<td>

<?php

if($produto['imagem'] != ""){

?>

<img
src="../../<?= $produto['imagem']; ?>"
width="70"
height="70"
style="object-fit:cover;border-radius:8px;">

<?php

}else{

?>

<img
src="../img/sem-imagem.png"
width="70">

<?php } ?>

</td>

<td><?= $produto['nome']; ?></td>

<td><?= $produto['categoria']; ?></td>

<td>

R$
<?= number_format($produto['preco'],2,",","."); ?>

</td>

<td><?= $produto['estoque']; ?></td>

<td>

<a
href="editar.php?id=<?= $produto['id']; ?>"
class="editar">

<i class="fa-solid fa-pen"></i>

</a>

<a
href="excluir.php?id=<?= $produto['id']; ?>"
class="excluir"
onclick="return confirm('Deseja excluir este produto?')">

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