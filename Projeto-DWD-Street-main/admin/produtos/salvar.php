<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

$nome = trim($_POST['nome']);
$descricao = trim($_POST['descricao']);
$preco = $_POST['preco'];
$estoque = $_POST['estoque'];
$categoria = $_POST['categoria'];

$imagem = "";

/* Upload da imagem */

if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){

    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

    $permitidas = ['jpg','jpeg','png','webp'];

    if(in_array($extensao,$permitidas)){

        $novoNome = uniqid("produto_") . "." . $extensao;

        $destino = "../../uploads/produtos/" . $novoNome;

        move_uploaded_file($_FILES['imagem']['tmp_name'],$destino);

        $imagem = "uploads/produtos/" . $novoNome;

    }

}

$sql = "INSERT INTO produtos
(nome,descricao,preco,estoque,imagem,categoria)
VALUES
(?,?,?,?,?,?)";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"ssdiss",
$nome,
$descricao,
$preco,
$estoque,
$imagem,
$categoria
);

if(mysqli_stmt_execute($stmt)){

    header("Location: index.php?sucesso=1");
    exit();

}else{

    echo "Erro ao cadastrar produto.";

}