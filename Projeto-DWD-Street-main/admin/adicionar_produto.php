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

if(isset($_POST["salvar"])){

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $estoque = $_POST["estoque"];
    $categoria = $_POST["categoria"];
    $imagem = $_POST["imagem"];

    $sql = "INSERT INTO produtos
    (
    nome,
    descricao,
    preco,
    estoque,
    imagem,
    categoria
    )
    VALUES
    (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssdiss",
        $nome,
        $descricao,
        $preco,
        $estoque,
        $imagem,
        $categoria
    );

    $stmt->execute();

    header("Location: produtos.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Novo Produto | DWD Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#0f0f0f;
    color:#fff;
    font-family:'Montserrat',sans-serif;
}

.container{
    max-width:700px;
    margin:50px auto;
    padding:30px;
}

.form-box{
    background:#1a1a1a;
    padding:30px;
    border-radius:15px;
    border:1px solid #2b2b2b;
}

h1{
    text-align:center;
    margin-bottom:25px;
    font-weight:900;
}

h1 span{
    color:#e31e24;
}

.form-group{
    margin-bottom:15px;
}

input,
textarea{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    background:#252525;
    color:white;
    font-size:15px;
}

textarea{
    resize:none;
    height:120px;
}

input:focus,
textarea:focus{
    outline:none;
    border:1px solid #e31e24;
}

.btn-salvar{
    width:100%;
    background:#e31e24;
    color:white;
    border:none;
    padding:15px;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    font-weight:700;
    transition:0.3s;
}

.btn-salvar:hover{
    background:#c4171d;
}

.btn-voltar{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    color:white;
    background:#252525;
    padding:10px 15px;
    border-radius:8px;
}

.btn-voltar:hover{
    background:#333;
}

</style>
</head>
<body>

<div class="container">

<a href="produtos.php" class="btn-voltar">
← Voltar
</a>

<div class="form-box">

<h1>📦 Novo <span>Produto</span></h1>

<form method="POST">

<div class="form-group">
<input type="text" name="nome" placeholder="Nome do Produto" required>
</div>

<div class="form-group">
<textarea name="descricao" placeholder="Descrição do Produto"></textarea>
</div>

<div class="form-group">
<input type="number" step="0.01" name="preco" placeholder="Preço" required>
</div>

<div class="form-group">
<input type="number" name="estoque" placeholder="Quantidade em Estoque" required>
</div>

<div class="form-group">
<input type="text" name="categoria" placeholder="Categoria">
</div>

<div class="form-group">
<input type="text" name="imagem" placeholder="assets/css/img/produto1.png">
</div>

<button type="submit" name="salvar" class="btn-salvar">
💾 Salvar Produto
</button>

</form>

</div>

</div>

</body>
</html>