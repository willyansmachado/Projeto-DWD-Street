<?php
session_start();
include("config/conexao.php");

if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];

$sql = "DELETE FROM carrinho WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: carrinho.php");
exit();
?>