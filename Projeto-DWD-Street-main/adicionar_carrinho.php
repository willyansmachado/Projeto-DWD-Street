<?php
session_start();
include("config/conexao.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];
$produto_nome = $_POST["produto_nome"];
$preco = $_POST["preco"];
$imagem = $_POST["imagem"];

$sql = "INSERT INTO carrinho
(usuario_id, produto_nome, preco, imagem, quantidade)
VALUES (?, ?, ?, ?, 1)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "isds",
    $usuario_id,
    $produto_nome,
    $preco,
    $imagem
);

$stmt->execute();

header("Location: carrinho.php");
exit();
?>