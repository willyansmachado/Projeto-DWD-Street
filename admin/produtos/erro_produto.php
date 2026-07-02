<?php
session_start();

if (!isset($_SESSION["erro_produto"])) {
    header("Location: index.php");
    exit();
}

$mensagem = $_SESSION["erro_produto"];
unset($_SESSION["erro_produto"]);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>DWD Street | Atenção</title>

<link rel="stylesheet" href="../css/admin.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{

    background:#111;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;

}

.card{

    width:650px;
    background:#1b1b1b;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 20px 40px rgba(0,0,0,.45);

}

.topo{

    height:8px;
    background:#d90429;

}
.conteudo{

padding:35px;

text-align:center;

}

.icone{

width:75px;
height:75px;
    margin:auto;
    margin-bottom:25px;

    background:rgba(217,4,41,.15);

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

}

.icone i{
font-size:34px;
    color:#d90429;

}

h1{

    color:#fff;
    font-size:30px;
    margin-bottom:18px;

}

.subtitulo{

color:#d5d5d5;
font-size:15px;
    line-height:28px;
    margin-bottom:30px;

}

.aviso{

background:#262626;

border-left:4px solid #d90429;

border-radius:8px;

padding:12px 16px;

color:#e6e6e6;

text-align:left;

margin-bottom:25px;

line-height:22px;

font-size:15px;

}

.btn{

display:inline-flex;

align-items:center;

gap:8px;

background:#d90429;

color:#fff;

text-decoration:none;

padding:10px 22px;

border-radius:8px;

font-size:14px;

font-weight:600;

transition:.25s;

}

.btn:hover{

    background:#b00020;

    transform:translateY(-2px);

}

</style>

</head>

<body>

<div class="card">

<div class="topo"></div>

<div class="conteudo">

<div class="icone">

<i class="fa-solid fa-triangle-exclamation"></i>

</div>

<h1>Não foi possível concluir o cadastro</h1>

<p class="subtitulo">

O produto não foi salvo porque encontramos uma informação que precisa ser corrigida.

</p>

<div class="aviso">

<?= $mensagem; ?>

</div>

<a href="criar.php" class="btn">

<i class="fa-solid fa-arrow-left"></i>

Voltar ao cadastro

</a>

</div>

</div>

</body>

</html>