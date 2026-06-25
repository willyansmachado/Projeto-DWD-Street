<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if($_SERVER["REQUEST_METHOD"]!="POST"){
    header("Location:index.php");
    exit();
}

$id = (int) $_POST['id'];

$status = $_POST['status_pedido'];

$rastreio = trim($_POST['codigo_rastreio']);

$sql = "UPDATE pedidos
        SET
            status_pedido=?,
            codigo_rastreio=?
        WHERE id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"ssi",
$status,
$rastreio,
$id
);

if(mysqli_stmt_execute($stmt)){

header("Location:index.php?editado=1");

}else{

echo "Erro ao atualizar pedido.";

}