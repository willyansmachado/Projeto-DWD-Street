<?php
include("proteger.php");
include("../config/conexao.php");

$id = $_GET["id"];

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: usuarios.php");
exit();
?><?php
include("proteger.php");
include("../config/conexao.php");

$id = $_GET["id"];

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: usuarios.php");
exit();
?>