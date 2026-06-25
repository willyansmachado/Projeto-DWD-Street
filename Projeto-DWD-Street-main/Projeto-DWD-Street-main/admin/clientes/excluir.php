<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if (!isset($_GET['id'])) {
    header("Location:index.php");
    exit();
}

$id = (int)$_GET['id'];

/* Não permite excluir o administrador principal */

if ($id == 1) {

    header("Location:index.php?erro=1");
    exit();

}

$sql = "DELETE FROM usuarios WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    header("Location:index.php?excluido=1");

} else {

    echo "Erro ao excluir cliente.";

}