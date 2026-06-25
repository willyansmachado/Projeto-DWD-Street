<?php
session_start();

if(
    !isset($_SESSION["nivel"])
    ||
    $_SESSION["nivel"] != "admin"
){
    die("Acesso negado");
}

include("../config/conexao.php");

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gerenciar Produtos</title>

<style>

body{
    background:#111;
    color:white;
    font-family:Arial;
}

.container{
    width:95%;
    max-width:1200px;
    margin:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#1c1c1c;
}

th{
    background:#e31e24;
    padding:12px;
}

td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #333;
}

a{
    text-decoration:none;
}

.btn{
    padding:8px 15px;
    border-radius:5px;
    color:white;
}

.editar{
    background:#007bff;
}

.excluir{
    background:#dc3545;
}

.novo{
    background:#28a745;
    display:inline-block;
    margin-bottom:20px;
}

img{
    border-radius:5px;
}

</style>

</head>
<body>

<div class="container">

<h1>Gerenciar Produtos</h1>

<a href="adicionar_produto.php" class="btn novo">
+ Novo Produto
</a>

<table>

<tr>
<th>ID</th>
<th>Imagem</th>
<th>Nome</th>
<th>Preço</th>
<th>Estoque</th>
<th>Categoria</th>
<th>Ações</th>
</tr>

<?php while($produto = mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td>
<?php echo $produto["id"]; ?>
</td>

<td>
<img
src="../<?php echo $produto["imagem"]; ?>"
width="70"
>
</td>

<td>
<?php echo $produto["nome"]; ?>
</td>

<td>
R$ <?php echo number_format($produto["preco"],2,",","."); ?>
</td>

<td>
<?php echo $produto["estoque"]; ?>
</td>

<td>
<?php echo $produto["categoria"]; ?>
</td>

<td>

<a
href="editar_produto.php?id=<?php echo $produto["id"]; ?>"
class="btn editar"
>
Editar
</a>

<a
href="excluir_produto.php?id=<?php echo $produto["id"]; ?>"
class="btn excluir"
onclick="return confirm('Excluir produto?')"
>
Excluir
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>