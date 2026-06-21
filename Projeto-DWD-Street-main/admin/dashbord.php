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

$totalProdutos = mysqli_num_rows(
    mysqli_query($conn,"SELECT id FROM produtos")
);

$totalPedidos = mysqli_num_rows(
    mysqli_query($conn,"SELECT id FROM pedidos")
);

$totalUsuarios = mysqli_num_rows(
    mysqli_query($conn,"SELECT id FROM usuarios")
);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Painel Admin</title>

<style>

body{
    background:#111;
    color:white;
    font-family:Arial;
}

.container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

.cards{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
}

.card{
    background:#1c1c1c;
    padding:30px;
    border-radius:10px;
    text-align:center;
}

.card h2{
    color:#e31e24;
}

.menu{
    margin:30px 0;
}

.menu a{
    color:white;
    text-decoration:none;
    margin-right:20px;
}

</style>

</head>
<body>

<div class="container">

<h1>Painel Administrativo DWD</h1>

<div class="menu">
<a href="produtos.php">Produtos</a>
<a href="pedidos.php">Pedidos</a>
<a href="usuarios.php">Usuários</a>
</div>

<div class="cards">

<div class="card">
<h2><?php echo $totalProdutos; ?></h2>
Produtos
</div>

<div class="card">
<h2><?php echo $totalPedidos; ?></h2>
Pedidos
</div>

<div class="card">
<h2><?php echo $totalUsuarios; ?></h2>
Usuários
</div>

</div>

</div>

</body>
</html>