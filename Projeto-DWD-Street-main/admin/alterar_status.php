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

$id = $_POST["pedido"];
$status = $_POST["status"];

$sql = "UPDATE pedidos
SET status_pedido = ?
WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "si",
    $status,
    $id
);

$stmt->execute();

header("Location: pedidos.php");